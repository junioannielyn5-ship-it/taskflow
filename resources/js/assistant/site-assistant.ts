type ChatLink = {
    label: string;
    path: string;
};

export {};

type KnowledgeItem = {
    title: string;
    keywords: string[];
    summary: string;
    steps?: string[];
    links?: ChatLink[];
};

declare global {
    interface Window {
        __mvChatbotMounted?: boolean;
    }
}

const knowledgeBase: KnowledgeItem[] = [
    {
        title: 'Website Overview',
        keywords: ['website', 'overview', 'content', 'modules', 'menu', 'navigation'],
        summary: 'Movaflex Task Manager includes Dashboard, Projects, Tasks, Kanban, Calendar, Notifications, Email Alerts, Reports, and role pages (Admin, Manager, Project Manager, Executive, Lead).',
        links: [
            { label: 'Dashboard', path: '/dashboard' },
            { label: 'Projects', path: '/projects' },
            { label: 'Tasks', path: '/tasks' },
            { label: 'Kanban', path: '/tasks/kanban' },
            { label: 'Calendar', path: '/tasks/calendar' },
            { label: 'Notifications', path: '/notifications/history' },
            { label: 'Email Alerts', path: '/email' },
            { label: 'Reports', path: '/reports' },
        ],
    },
    {
        title: 'Create Task (Step by Step)',
        keywords: ['create task', 'new task', 'task step', 'task guide'],
        summary: 'You can create a task from Task page or Dashboard.',
        steps: [
            'Open Tasks menu then click Create Task.',
            'Select Project and fill Task Title.',
            'Set status, priority, and due date.',
            'Add assignees and details (company, process, deliverables, remarks).',
            'Click Save/Create and verify it appears in Task list or Kanban.',
        ],
        links: [{ label: 'Create Task', path: '/tasks/create' }, { label: 'Task List', path: '/tasks' }],
    },
    {
        title: 'Create Project (Step by Step)',
        keywords: ['create project', 'new project', 'project step', 'project guide'],
        summary: 'Project setup is available for authorized users.',
        steps: [
            'Go to Projects then click Create Project.',
            'Enter project name and description.',
            'Set project status and key dates if available.',
            'Assign owner or members as needed.',
            'Save and confirm project appears in Projects list.',
        ],
        links: [{ label: 'Projects', path: '/projects' }, { label: 'Create Project', path: '/projects/create' }],
    },
    {
        title: 'Task Status Flow',
        keywords: ['status', 'workflow', 'not started', 'ongoing', 'for review', 'done', 'overdue'],
        summary: 'Standard flow: Not Started (todo) -> On Going (in_progress) -> For Review -> Done. Overdue means due date already passed while not done.',
        steps: [
            'Start in NOT STARTED (todo).',
            'Move to ON GOING (in_progress) when work begins.',
            'Move to FOR REVIEW when output is ready for checking.',
            'Approve to DONE after validation.',
            'If due date is passed and not done, task appears as OVERDUE.',
        ],
        links: [{ label: 'Task Board', path: '/tasks' }, { label: 'Kanban', path: '/tasks/kanban' }],
    },
    {
        title: 'Email Alerts and Recipients',
        keywords: ['email', 'alerts', 'bcc', 'cc', 'mail header', 'deadline alert'],
        summary: 'Email Alerts page shows warning/critical/reminder/overdue levels and recipient preview (From, To, CC, BCC).',
        steps: [
            'Open Email Alert page from top nav or sidebar.',
            'Review Mail Header Preview to see sender and recipients.',
            'Check warning, critical, reminder, and overdue sections.',
            'Use test email actions if available in local environment.',
        ],
        links: [{ label: 'Email Alerts', path: '/email' }, { label: 'Admin Configuration', path: '/admin/configuration' }],
    },
    {
        title: 'Reports Usage',
        keywords: ['report', 'analytics', 'metrics', 'executive update'],
        summary: 'Reports page provides workload, overdue, completion, and lead-time visibility for management decisions.',
        links: [{ label: 'Reports', path: '/reports' }],
    },
];

const quickPrompts = [
    {
        en: ['Website overview', 'How to create task', 'How to create project', 'Task status flow', 'Email alerts recipients'],
        fil: ['Buod ng website', 'Paano gumawa ng task', 'Paano gumawa ng project', 'Daloy ng task status', 'Recipients ng email alerts'],
    },
];

type LanguageCode = 'en' | 'fil';

type ChatResponse = {
    title: string;
    summary: string;
    steps?: string[];
    links?: ChatLink[];
};

function normalize(text: string): string {
    return text.toLowerCase().trim();
}

function scoreItem(question: string, item: KnowledgeItem): number {
    const q = normalize(question);

    return item.keywords.reduce((score, keyword) => {
        const k = normalize(keyword);
        if (q.includes(k)) {
            return score + Math.max(1, k.length / 6);
        }
        return score;
    }, 0);
}

function findBestAnswer(question: string): KnowledgeItem | null {
    const scored = knowledgeBase
        .map((item) => ({ item, score: scoreItem(question, item) }))
        .sort((a, b) => b.score - a.score);

    if (scored.length === 0 || scored[0].score <= 0) {
        return null;
    }

    return scored[0].item;
}

function linkUrl(path: string): string {
    return `${window.location.origin}${path}`;
}

function getCsrfToken(): string {
    const el = document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement | null;
    return el?.content ?? '';
}

function createEl<K extends keyof HTMLElementTagNameMap>(tag: K, className?: string, text?: string): HTMLElementTagNameMap[K] {
    const el = document.createElement(tag);
    if (className) {
        el.className = className;
    }
    if (text) {
        el.textContent = text;
    }
    return el;
}

function appendBotMessage(container: HTMLElement, title: string, body: string, steps: string[] = [], links: ChatLink[] = []): void {
    const message = createEl('div', 'mv-chatbot-message mv-chatbot-message-bot');

    const titleEl = createEl('p', 'mv-chatbot-message-title', title);
    const bodyEl = createEl('p', 'mv-chatbot-message-text', body);

    message.appendChild(titleEl);
    message.appendChild(bodyEl);

    if (steps.length > 0) {
        const stepTitle = createEl('p', 'mv-chatbot-message-subtitle', 'Step-by-step:');
        const list = createEl('ol', 'mv-chatbot-step-list');
        steps.forEach((step) => {
            const li = createEl('li', '', step);
            list.appendChild(li);
        });
        message.appendChild(stepTitle);
        message.appendChild(list);
    }

    if (links.length > 0) {
        const linksWrap = createEl('div', 'mv-chatbot-links');
        links.forEach((link) => {
            const anchor = createEl('a', 'mv-chatbot-link-pill', link.label);
            anchor.setAttribute('href', linkUrl(link.path));
            linksWrap.appendChild(anchor);
        });
        message.appendChild(linksWrap);
    }

    container.appendChild(message);
    container.scrollTop = container.scrollHeight;
}

function appendUserMessage(container: HTMLElement, text: string): void {
    const message = createEl('div', 'mv-chatbot-message mv-chatbot-message-user', text);
    container.appendChild(message);
    container.scrollTop = container.scrollHeight;
}

function buildAssistant(): void {
    if (typeof window === 'undefined' || typeof document === 'undefined') {
        return;
    }

    if (window.__mvChatbotMounted) {
        return;
    }

    window.__mvChatbotMounted = true;

    const root = createEl('div', 'mv-chatbot-root');
    const panel = createEl('section', 'mv-chatbot-panel');
    const header = createEl('div', 'mv-chatbot-header');
    const titleWrap = createEl('div', 'mv-chatbot-header-text');
    const title = createEl('h3', 'mv-chatbot-title', 'Movaflex Help Chatbot');
    const subtitle = createEl('p', 'mv-chatbot-subtitle', 'Ask about steps, modules, and page guides.');
    const languageWrap = createEl('div', 'mv-chatbot-language-wrap');
    const langEnBtn = createEl('button', 'mv-chatbot-language is-active', 'EN');
    const langFilBtn = createEl('button', 'mv-chatbot-language', 'FIL');
    langEnBtn.setAttribute('type', 'button');
    langFilBtn.setAttribute('type', 'button');
    const closeBtn = createEl('button', 'mv-chatbot-close', 'x');
    closeBtn.setAttribute('type', 'button');

    titleWrap.appendChild(title);
    titleWrap.appendChild(subtitle);
    languageWrap.appendChild(langEnBtn);
    languageWrap.appendChild(langFilBtn);
    header.appendChild(titleWrap);
    header.appendChild(languageWrap);
    header.appendChild(closeBtn);

    const quickWrap = createEl('div', 'mv-chatbot-quick-wrap');
    let language: LanguageCode = 'en';

    function renderQuickPrompts(): void {
        quickWrap.innerHTML = '';
        const list = quickPrompts[0][language];
        list.forEach((prompt) => {
            const btn = createEl('button', 'mv-chatbot-quick', prompt);
            btn.setAttribute('type', 'button');
            btn.addEventListener('click', () => {
                input.value = prompt;
                void sendQuestion();
            });
            quickWrap.appendChild(btn);
        });
    }

    const messages = createEl('div', 'mv-chatbot-messages');

    const form = createEl('form', 'mv-chatbot-form');
    const input = createEl('input', 'mv-chatbot-input') as HTMLInputElement;
    input.type = 'text';
    input.placeholder = 'Type your question here...';

    const send = createEl('button', 'mv-chatbot-send', 'Send');
    send.setAttribute('type', 'submit');

    form.appendChild(input);
    form.appendChild(send);

    async function sendQuestion(): Promise<void> {
        const question = input.value.trim();
        if (!question) {
            return;
        }

        appendUserMessage(messages, question);
        input.value = '';

        try {
            const response = await fetch('/chatbot/query', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken(),
                },
                body: JSON.stringify({ question, language }),
            });

            if (response.ok) {
                const payload = (await response.json()) as { ok: boolean; data?: ChatResponse };
                if (payload.ok && payload.data) {
                    appendBotMessage(
                        messages,
                        payload.data.title,
                        payload.data.summary,
                        payload.data.steps ?? [],
                        payload.data.links ?? [],
                    );
                    return;
                }
            }
        } catch {
            // Use local fallback when backend is unavailable.
        }

        const best = findBestAnswer(question);

        if (!best) {
            appendBotMessage(
                messages,
                language === 'fil' ? 'Walang eksaktong tugma' : 'No exact match yet',
                language === 'fil'
                    ? 'Subukan ang keywords: create task, create project, status flow, email alerts, reports, o website overview.'
                    : 'Please try keywords like: create task, create project, status flow, email alerts, reports, or website overview.',
                [],
                [{ label: 'Dashboard', path: '/dashboard' }, { label: 'Tasks', path: '/tasks' }, { label: 'Email Alerts', path: '/email' }],
            );
            return;
        }

        appendBotMessage(messages, best.title, best.summary, best.steps ?? [], best.links ?? []);
    }

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        void sendQuestion();
    });

    langEnBtn.addEventListener('click', () => {
        language = 'en';
        langEnBtn.classList.add('is-active');
        langFilBtn.classList.remove('is-active');
        subtitle.textContent = 'Ask about steps, modules, and page guides.';
        input.placeholder = 'Type your question here...';
        renderQuickPrompts();
    });

    langFilBtn.addEventListener('click', () => {
        language = 'fil';
        langFilBtn.classList.add('is-active');
        langEnBtn.classList.remove('is-active');
        subtitle.textContent = 'Magtanong tungkol sa steps, modules, at page guides.';
        input.placeholder = 'I-type ang tanong mo dito...';
        renderQuickPrompts();
    });

    panel.appendChild(header);
    panel.appendChild(quickWrap);
    panel.appendChild(messages);
    panel.appendChild(form);

    const launcher = createEl('button', 'mv-chatbot-launcher', 'Help');
    launcher.setAttribute('type', 'button');

    const unreadDot = createEl('span', 'mv-chatbot-launcher-dot');
    launcher.appendChild(unreadDot);

    let isOpen = false;

    function setOpen(next: boolean): void {
        isOpen = next;
        panel.classList.toggle('is-open', isOpen);
        launcher.classList.toggle('is-open', isOpen);
        if (isOpen) {
            unreadDot.classList.add('is-hidden');
            input.focus();
        }
    }

    launcher.addEventListener('click', () => setOpen(!isOpen));
    closeBtn.addEventListener('click', () => setOpen(false));
    document.addEventListener('click', (event) => {
        const target = event.target instanceof Element ? event.target.closest('[data-open-chatbot]') : null;

        if (!target) {
            return;
        }

        event.preventDefault();
        setOpen(true);
    });

    root.appendChild(panel);
    root.appendChild(launcher);
    document.body.appendChild(root);

    renderQuickPrompts();

    appendBotMessage(
        messages,
        'Welcome',
        'I can guide users step-by-step for Tasks, Projects, Email Alerts, Reports, and other Movaflex modules.',
        [
            'Ask a question using the input below.',
            'Or click a quick prompt.',
            'Open suggested links directly from answers.',
        ],
        [{ label: 'Website Overview', path: '/dashboard' }, { label: 'Open Tasks', path: '/tasks' }],
    );
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', buildAssistant);
} else {
    buildAssistant();
}
