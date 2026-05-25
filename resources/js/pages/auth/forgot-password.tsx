// Components
import { Form, Head } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';
import InputError from '@/components/input-error';
import TextLink from '@/components/text-link';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthLayout from '@/layouts/auth-layout';
import { login } from '@/routes';

export default function ForgotPassword({ status }: { status?: string }) {
    return (
        <AuthLayout
            title="Forgot password"
            description="Enter your email to receive a password reset link"
        >
            <Head title="Forgot password" />

            {status && (
                <div className="mb-4 text-center text-sm font-medium text-green-600">
                    {status}
                </div>
            )}

            <div className="rounded-2xl border border-amber-500/30 dark:border-amber-300/40 bg-amber-50 dark:bg-amber-500/10 px-5 py-4 text-[13px] leading-relaxed text-amber-900 dark:text-amber-100 shadow-sm">
                <p className="font-bold uppercase tracking-wider text-amber-700 dark:text-amber-200 text-xs mb-1.5">Local Testing Tip</p>
                <p>
                    If reset email is not delivered, open{' '}
                    <a
                        href="/dev/password-reset-link?email=admin@test.com"
                        className="font-bold text-amber-700 dark:text-amber-200 underline underline-offset-4 hover:text-amber-900 dark:hover:text-amber-50 transition-colors"
                    >
                        direct reset link (local only)
                    </a>
                    {' '}using your account email.
                </p>
            </div>

            <div className="space-y-6">
                <Form method="post" action="/forgot-password-local">
                    {({ processing, errors }) => (
                        <>
                            <div className="grid gap-2">
                                <Label htmlFor="email">Email address</Label>
                                <Input
                                    id="email"
                                    type="email"
                                    name="email"
                                    autoComplete="off"
                                    autoFocus
                                    placeholder="email@example.com"
                                />

                                <InputError message={errors.email} />
                            </div>

                            <div className="my-6 flex items-center justify-start">
                                <Button
                                    className="w-full"
                                    disabled={processing}
                                    data-test="email-password-reset-link-button"
                                >
                                    {processing && (
                                        <LoaderCircle className="h-4 w-4 animate-spin" />
                                    )}
                                    Email password reset link
                                </Button>
                            </div>
                        </>
                    )}
                </Form>

                <div className="space-x-1 text-center text-sm text-muted-foreground">
                    <span>Or, return to</span>
                    <TextLink href={login()}>log in</TextLink>
                </div>
            </div>
        </AuthLayout>
    );
}
