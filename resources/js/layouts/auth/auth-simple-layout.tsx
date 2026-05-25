import { Link } from '@inertiajs/react';
import { home } from '@/routes';
import type { AuthLayoutProps } from '@/types';
import { useEffect } from 'react';

export default function AuthSimpleLayout({
    children,
    title,
    description,
}: AuthLayoutProps) {
    useEffect(() => {
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }, []);

    return (
        <div
            className="flex min-h-screen selection:bg-blue-500/30 selection:text-blue-900 dark:selection:text-white relative overflow-hidden bg-slate-50 dark:bg-slate-950 transition-colors duration-300"
            style={{ fontFamily: "'Inter', sans-serif" }}
        >
            {/* ═══ GLOBAL BACKGROUND ORBS ═══ */}
            <div className="pointer-events-none absolute -top-40 -left-40 h-[500px] w-[500px] rounded-full bg-blue-400/30 dark:bg-blue-600/20 blur-[120px] animate-pulse" />
            <div className="pointer-events-none absolute top-1/4 right-0 h-96 w-96 rounded-full bg-cyan-400/20 dark:bg-cyan-600/20 blur-[100px] animate-pulse [animation-delay:2s]" />
            <div className="pointer-events-none absolute right-1/3 bottom-0 h-[450px] w-[450px] rounded-full bg-emerald-400/20 dark:bg-emerald-600/20 blur-[120px]" />
            <div className="pointer-events-none absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 h-[300px] w-[300px] rounded-full bg-purple-400/20 dark:bg-purple-600/20 blur-[100px]" />

            {/* Dark Mode Toggle */}
            <button
                onClick={() => {
                    const isDark = document.documentElement.classList.toggle('dark');
                    localStorage.setItem('theme', isDark ? 'dark' : 'light');
                }}
                className="absolute top-6 right-6 z-50 flex h-10 w-10 items-center justify-center rounded-full bg-white/40 dark:bg-slate-800/40 border border-white/60 dark:border-white/10 backdrop-blur-md shadow-sm text-slate-700 dark:text-amber-400 hover:bg-white/60 dark:hover:bg-slate-700/50 transition-all duration-300"
                aria-label="Toggle dark mode"
            >
                <svg className="h-5 w-5 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2"><path strokeLinecap="round" strokeLinejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                <svg className="h-5 w-5 block dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2"><path strokeLinecap="round" strokeLinejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
            </button>

            {/* ═══ LEFT HALF — Brand Identity ═══ */}
            <div className="relative hidden w-1/2 flex-col items-center justify-center p-12 lg:flex border-r border-slate-200/50 dark:border-white/10 bg-white/40 dark:bg-slate-900/30 backdrop-blur-2xl transition-colors duration-300">
                {/* Subtle grain overlay */}
                <div className="pointer-events-none absolute inset-0 opacity-[0.02]" style={{ backgroundImage: 'url("data:image/svg+xml,%3Csvg viewBox=\'0 0 256 256\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cfilter id=\'noise\'%3E%3CfeTurbulence type=\'fractalNoise\' baseFrequency=\'0.9\' numOctaves=\'4\' stitchTiles=\'stitch\'/%3E%3C/filter%3E%3Crect width=\'100%25\' height=\'100%25\' filter=\'url(%23noise)\' opacity=\'0.5\'/%3E%3C/svg%3E")' }} />

                {/* Centered brand content */}
                <div className="relative z-10 flex flex-col items-center text-center">
                    <Link href={home()} className="group inline-block transition-transform duration-500 hover:scale-105">
                        <img
                            src="/images/movaflex-logo-official.png"
                            alt="Movaflex Logo"
                            className="h-40 w-auto object-contain saturate-125 contrast-110 brightness-105 dark:saturate-100 dark:contrast-150 dark:brightness-150 drop-shadow-[0_0_15px_rgba(59,130,246,0.3)] transition-all duration-500 group-hover:drop-shadow-[0_0_25px_rgba(59,130,246,0.6)]"
                        />
                    </Link>

                    <div className="mt-10 max-w-sm">
                        <span className="inline-block rounded-full border border-blue-400/30 bg-blue-50 dark:bg-blue-500/10 px-4 py-1.5 text-[10px] font-bold uppercase tracking-[0.25em] text-blue-600 dark:text-blue-300 backdrop-blur-sm shadow-sm">
                            Task Operations
                        </span>

                        <h1 className="mt-7 text-3xl font-extrabold leading-[1.2] tracking-tight text-slate-800 dark:text-white xl:text-[2.5rem]">
                            Streamline your{' '}
                            <span className="bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-500 dark:from-blue-400 dark:via-cyan-300 dark:to-emerald-300 bg-clip-text text-transparent drop-shadow-sm">
                                workflow.
                            </span>
                        </h1>

                        <p className="mt-5 text-sm leading-relaxed text-slate-600 dark:text-slate-400 font-medium">
                            Planning, delivery, and accountability in one clear system.
                        </p>
                    </div>

                    {/* Feature pills */}
                    <div className="mt-12 flex gap-3">
                        {[
                            { label: 'Tasks', color: 'bg-blue-500', glow: 'shadow-[0_0_8px_rgba(59,130,246,0.5)]' },
                            { label: 'Approvals', color: 'bg-emerald-500', glow: 'shadow-[0_0_8px_rgba(16,185,129,0.5)]' },
                            { label: 'Insights', color: 'bg-purple-500', glow: 'shadow-[0_0_8px_rgba(168,85,247,0.5)]' },
                        ].map((item) => (
                            <div
                                key={item.label}
                                className="flex items-center gap-2 rounded-full border border-slate-200/80 dark:border-white/10 bg-white/60 dark:bg-slate-800/40 px-4 py-2 backdrop-blur-md shadow-sm transition-colors duration-300"
                            >
                                <div className={`h-2 w-2 rounded-full ${item.glow} ${item.color}`} />
                                <span className="text-[11px] font-bold text-slate-700 dark:text-slate-200">{item.label}</span>
                            </div>
                        ))}
                    </div>
                </div>

                {/* Bottom footer */}
                <div className="absolute bottom-8 left-0 right-0 z-10 text-center">
                    <p className="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-500">
                        © {new Date().getFullYear()} Movaflex
                    </p>
                </div>
            </div>

            {/* ═══ RIGHT HALF — Form Area ═══ */}
            <div className="relative flex w-full flex-col items-center justify-center p-6 lg:w-1/2 bg-transparent z-10">
                
                {/* Mobile logo */}
                <div className="mb-8 flex justify-center lg:hidden relative z-10">
                    <img
                        src="/images/movaflex-logo-official.png"
                        alt="Movaflex"
                        className="h-28 w-auto saturate-125 contrast-110 brightness-105 dark:saturate-100 dark:contrast-150 dark:brightness-150 drop-shadow-md"
                    />
                </div>

                {/* Glassmorphism card */}
                <div className="relative z-10 w-full max-w-[420px]">
                    <div className="rounded-[2rem] border border-white/60 dark:border-slate-700/50 bg-white/60 dark:bg-slate-900/50 p-8 shadow-[0_8px_40px_rgba(0,0,0,0.08)] dark:shadow-[0_8px_40px_rgba(0,0,0,0.4)] backdrop-blur-2xl sm:p-10 transition-colors duration-300
                        [&_[data-slot=label]]:text-[12px]
                        [&_[data-slot=label]]:font-semibold
                        [&_[data-slot=label]]:uppercase
                        [&_[data-slot=label]]:tracking-wider
                        [&_[data-slot=label]]:text-slate-600
                        dark:[&_[data-slot=label]]:text-slate-400
                        
                        [&_[data-slot=input]]:h-12
                        [&_[data-slot=input]]:rounded-2xl
                        [&_[data-slot=input]]:border-slate-300/50
                        dark:[&_[data-slot=input]]:border-white/10
                        [&_[data-slot=input]]:bg-white/50
                        dark:[&_[data-slot=input]]:bg-slate-900/40
                        [&_[data-slot=input]]:text-slate-900
                        dark:[&_[data-slot=input]]:text-white
                        [&_[data-slot=input]]:placeholder:text-slate-400
                        dark:[&_[data-slot=input]]:placeholder:text-slate-500
                        [&_[data-slot=input]]:focus-visible:border-blue-500/50
                        dark:[&_[data-slot=input]]:focus-visible:border-blue-400/50
                        [&_[data-slot=input]]:focus-visible:bg-white/80
                        dark:[&_[data-slot=input]]:focus-visible:bg-slate-800/60
                        [&_[data-slot=input]]:focus-visible:ring-blue-500/20
                        dark:[&_[data-slot=input]]:focus-visible:ring-blue-400/20
                        
                        [&_[data-slot=button]]:h-12
                        [&_[data-slot=button]]:rounded-2xl
                        [&_[data-slot=button]]:border-0
                        [&_[data-slot=button]]:bg-gradient-to-r
                        [&_[data-slot=button]]:from-blue-600
                        [&_[data-slot=button]]:to-cyan-500
                        dark:[&_[data-slot=button]]:from-blue-500
                        dark:[&_[data-slot=button]]:to-cyan-400
                        [&_[data-slot=button]]:text-sm
                        [&_[data-slot=button]]:font-bold
                        [&_[data-slot=button]]:text-white
                        [&_[data-slot=button]]:shadow-[0_4px_20px_rgba(59,130,246,0.25)]
                        [&_[data-slot=button]]:hover:shadow-[0_6px_30px_rgba(59,130,246,0.4)]
                        [&_[data-slot=button]]:hover:brightness-110
                        [&_[data-slot=button]]:active:scale-[0.98]
                        
                        [&_.text-muted-foreground]:text-slate-500
                        dark:[&_.text-muted-foreground]:text-slate-400
                        [&_a]:font-semibold
                        [&_a]:text-blue-600
                        dark:[&_a]:text-blue-400
                        [&_a]:hover:text-blue-700
                        dark:[&_a]:hover:text-blue-300">
                        <div className="relative">
                            <h2 className="text-[1.6rem] font-extrabold tracking-tight text-slate-800 dark:text-white">{title}</h2>
                            <p className="mt-2 text-[13px] font-medium leading-relaxed text-slate-500 dark:text-slate-400">
                                {description}
                            </p>

                            <div className="mt-8">
                                {children}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}