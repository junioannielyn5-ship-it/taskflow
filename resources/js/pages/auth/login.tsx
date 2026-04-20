import { Form, Head } from '@inertiajs/react';
import { Mail, Lock } from 'lucide-react';
import InputError from '@/components/input-error';
import TextLink from '@/components/text-link';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import AuthLayout from '@/layouts/auth-layout';
import { register } from '@/routes';
import { store } from '@/routes/login';
import { request } from '@/routes/password';

type Props = {
    status?: string;
    canResetPassword: boolean;
    canRegister: boolean;
};

export default function Login({
    status,
    canResetPassword,
    canRegister,
}: Props) {
    return (
        <AuthLayout
            title="Welcome back"
            description="Sign in to your account to continue where you left off."
        >
            <Head title="Log in" />

            {status && (
                <div className="mb-6 rounded-2xl border border-emerald-500/20 bg-emerald-500/10 px-4 py-3 text-center text-sm font-medium text-emerald-400 backdrop-blur-sm">
                    {status}
                </div>
            )}

            <Form
                {...store.form()}
                resetOnSuccess={['password']}
                className="flex flex-col gap-5"
            >
                {({ processing, errors }) => (
                    <>
                        <div className="grid gap-5">
                            {/* Email field */}
                            <div className="grid gap-2">
                                <Label htmlFor="email" className="text-[12px] font-semibold uppercase tracking-wider text-slate-400">
                                    Email
                                </Label>
                                <div className="relative">
                                    <Mail className="pointer-events-none absolute left-4 top-1/2 h-[18px] w-[18px] -translate-y-1/2 text-slate-500" />
                                    <input
                                        id="email"
                                        type="email"
                                        name="email"
                                        required
                                        autoFocus
                                        tabIndex={1}
                                        autoComplete="email"
                                        placeholder="you@company.com"
                                        className="h-12 w-full rounded-2xl border border-white/[0.08] bg-white/[0.04] pl-12 pr-4 text-sm text-white placeholder:text-slate-500 outline-none backdrop-blur-sm transition-all duration-300 focus:border-indigo-500/50 focus:bg-white/[0.06] focus:ring-2 focus:ring-indigo-500/20"
                                    />
                                </div>
                                <InputError message={errors.email} />
                            </div>

                            {/* Password field */}
                            <div className="grid gap-2">
                                <Label htmlFor="password" className="text-[12px] font-semibold uppercase tracking-wider text-slate-400">
                                    Password
                                </Label>
                                <div className="relative">
                                    <Lock className="pointer-events-none absolute left-4 top-1/2 h-[18px] w-[18px] -translate-y-1/2 text-slate-500" />
                                    <input
                                        id="password"
                                        type="password"
                                        name="password"
                                        required
                                        tabIndex={2}
                                        autoComplete="current-password"
                                        placeholder="••••••••"
                                        className="h-12 w-full rounded-2xl border border-white/[0.08] bg-white/[0.04] pl-12 pr-4 text-sm text-white placeholder:text-slate-500 outline-none backdrop-blur-sm transition-all duration-300 focus:border-indigo-500/50 focus:bg-white/[0.06] focus:ring-2 focus:ring-indigo-500/20"
                                    />
                                </div>
                                <InputError message={errors.password} />

                                {/* Forgot password — prominent placement */}
                                {canResetPassword && (
                                    <div className="mt-1 text-right">
                                        <TextLink
                                            href={request()}
                                            className="text-[12px] font-semibold tracking-wide text-indigo-400 no-underline transition-colors duration-200 hover:text-indigo-300"
                                            tabIndex={5}
                                        >
                                            Forgot password?
                                        </TextLink>
                                    </div>
                                )}
                            </div>

                            {/* Remember me */}
                            <div className="flex items-center space-x-3">
                                <Checkbox
                                    id="remember"
                                    name="remember"
                                    tabIndex={3}
                                    className="border-white/20 data-[state=checked]:bg-indigo-500 data-[state=checked]:border-indigo-500"
                                />
                                <Label htmlFor="remember" className="text-[13px] font-normal text-slate-400 cursor-pointer">
                                    Keep me signed in
                                </Label>
                            </div>

                            {/* Login button */}
                            <Button
                                type="submit"
                                className="mt-2 h-12 w-full rounded-2xl border-0 bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-600 text-sm font-semibold text-white shadow-[0_4px_30px_rgba(99,102,241,0.35)] transition-all duration-300 hover:shadow-[0_6px_40px_rgba(99,102,241,0.5)] hover:brightness-110 active:scale-[0.98]"
                                tabIndex={4}
                                disabled={processing}
                                data-test="login-button"
                            >
                                {processing && <Spinner className="text-white/80" />}
                                Sign in
                            </Button>
                        </div>
                    </>
                )}
            </Form>
        </AuthLayout>
    );
}
