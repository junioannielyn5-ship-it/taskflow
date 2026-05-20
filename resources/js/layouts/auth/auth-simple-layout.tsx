import { Link } from '@inertiajs/react';
import { home } from '@/routes';
import type { AuthLayoutProps } from '@/types';

export default function AuthSimpleLayout({
    children,
    title,
    description,
}: AuthLayoutProps) {
    return (
        <div
            className="flex min-h-screen selection:bg-indigo-400/30 selection:text-white"
            style={{ fontFamily: "'Inter', sans-serif" }}
        >
            {/* ═══ LEFT HALF — Brand Identity ═══ */}
            <div
                className="relative hidden w-1/2 flex-col items-center justify-center overflow-hidden lg:flex"
                style={{ background: 'linear-gradient(145deg, #020617 0%, #0f172a 40%, #1e1b4b 100%)' }}
            >
                {/* Gradient orbs */}
                <div className="absolute left-1/4 top-1/4 h-[420px] w-[420px] rounded-full bg-indigo-600/20 blur-[120px] animate-pulse" />
                <div className="absolute bottom-1/4 right-1/4 h-[350px] w-[350px] rounded-full bg-violet-600/15 blur-[100px] animate-pulse [animation-delay:2s]" />
                <div className="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 h-[200px] w-[200px] rounded-full bg-indigo-400/10 blur-[80px]" />

                {/* Subtle grain overlay */}
                <div className="pointer-events-none absolute inset-0 opacity-[0.04]" style={{ backgroundImage: 'url("data:image/svg+xml,%3Csvg viewBox=\'0 0 256 256\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cfilter id=\'noise\'%3E%3CfeTurbulence type=\'fractalNoise\' baseFrequency=\'0.9\' numOctaves=\'4\' stitchTiles=\'stitch\'/%3E%3C/filter%3E%3Crect width=\'100%25\' height=\'100%25\' filter=\'url(%23noise)\' opacity=\'0.5\'/%3E%3C/svg%3E")' }} />

                {/* Centered brand content */}
                <div className="relative z-10 flex flex-col items-center text-center">
                    <Link href={home()} className="group inline-block transition-transform duration-500 hover:scale-105">
                        <img
                            src="/images/movaflex-logo-official.png"
                            alt="Movaflex Logo"
                            className="h-14 w-auto object-contain brightness-0 invert drop-shadow-[0_0_30px_rgba(129,140,248,0.3)] transition-all duration-500 group-hover:drop-shadow-[0_0_40px_rgba(129,140,248,0.5)]"
                        />
                    </Link>

                    <div className="mt-10 max-w-xs">
                        <span className="inline-block rounded-full border border-indigo-400/20 bg-indigo-500/10 px-4 py-1.5 text-[10px] font-bold uppercase tracking-[0.25em] text-indigo-300 backdrop-blur-sm">
                            Task Operations
                        </span>

                        <h1 className="mt-7 text-3xl font-bold leading-[1.15] tracking-tight text-white xl:text-[2.5rem]">
                            Streamline your{' '}
                            <span className="bg-gradient-to-r from-indigo-400 via-violet-400 to-purple-400 bg-clip-text text-transparent">
                                workflow.
                            </span>
                        </h1>

                        <p className="mt-5 text-sm leading-relaxed text-slate-400/90">
                            Planning, delivery, and accountability in one clear system.
                        </p>
                    </div>

                    {/* Feature pills */}
                    <div className="mt-12 flex gap-3">
                        {[
                            { label: 'Tasks', color: 'bg-indigo-500' },
                            { label: 'Approvals', color: 'bg-violet-500' },
                            { label: 'Insights', color: 'bg-purple-500' },
                        ].map((item) => (
                            <div
                                key={item.label}
                                className="flex items-center gap-2 rounded-full border border-white/[0.08] bg-white/[0.04] px-4 py-2 backdrop-blur-md"
                            >
                                <div className={`h-1.5 w-1.5 rounded-full ${item.color}`} />
                                <span className="text-[11px] font-medium text-slate-300">{item.label}</span>
                            </div>
                        ))}
                    </div>
                </div>

                {/* Bottom footer */}
                <div className="absolute bottom-8 left-0 right-0 z-10 text-center">
                    <p className="text-[10px] font-medium uppercase tracking-[0.2em] text-slate-600">
                        © {new Date().getFullYear()} Movaflex
                    </p>
                </div>
            </div>

            {/* ═══ RIGHT HALF — Form Area ═══ */}
            <div
                className="relative flex w-full flex-col items-center justify-center overflow-hidden lg:w-1/2"
                style={{ background: 'linear-gradient(180deg, #0f172a 0%, #1e1b4b 50%, #0f172a 100%)' }}
            >
                {/* Ambient glow behind card */}
                <div className="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 h-[500px] w-[500px] rounded-full bg-indigo-600/[0.07] blur-[100px]" />

                {/* Mobile logo */}
                <div className="mb-8 flex justify-center lg:hidden">
                    <img
                        src="/images/movaflex-logo-official.png"
                        alt="Movaflex"
                        className="h-10 w-auto brightness-0 invert"
                    />
                </div>

                {/* Glassmorphism card */}
                <div className="relative z-10 w-full max-w-[420px] px-6 sm:px-0">
                    <div className="rounded-[2rem] border border-white/[0.12] bg-white/[0.08] p-8 shadow-[0_8px_60px_rgba(0,0,0,0.4)] backdrop-blur-xl sm:p-10
                        [&_[data-slot=label]]:text-slate-200
                        [&_[data-slot=input]]:bg-white/[0.08]
                        [&_[data-slot=input]]:border-white/20
                        [&_[data-slot=input]]:text-white
                        [&_[data-slot=input]]:placeholder:text-slate-400
                        [&_[data-slot=input]]:focus-visible:border-indigo-400
                        [&_[data-slot=input]]:focus-visible:ring-indigo-400/30
                        [&_[data-slot=button]]:bg-gradient-to-r
                        [&_[data-slot=button]]:from-indigo-600
                        [&_[data-slot=button]]:to-violet-600
                        [&_[data-slot=button]]:text-white
                        [&_[data-slot=button]]:hover:from-indigo-500
                        [&_[data-slot=button]]:hover:to-violet-500
                        [&_[data-slot=button]]:shadow-[0_8px_30px_rgba(79,70,229,0.35)]
                        [&_.text-muted-foreground]:text-slate-300
                        [&_a]:text-indigo-300
                        [&_a]:hover:text-indigo-200">
                        {/* Inner subtle border highlight */}
                        <div className="pointer-events-none absolute inset-[1px] rounded-[calc(2rem-1px)] border border-white/[0.06]" />

                        <div className="relative">
                            <h2 className="text-[1.6rem] font-bold tracking-tight text-white">{title}</h2>
                            <p className="mt-2 text-[13px] leading-relaxed text-slate-400">
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