import { Head, Link, useForm } from '@inertiajs/react';

export default function Login() {
    const form = useForm({ email: '', password: '' });

    function submit(event) {
        event.preventDefault();
        form.post('/admin/login');
    }

    return (
        <main className="admin-login">
            <Head title="Admin sign in — AK PALETTES" />
            <section className="admin-login-card">
                <Link className="admin-brand admin-login-brand" href="/">
                    <span className="wordmark-mark">AK</span>
                    <span><strong>PALETTES</strong><small>STUDIO ADMIN</small></span>
                </Link>
                <p className="admin-eyebrow">WELCOME BACK</p>
                <h1>Your studio,<br /><em>your stories.</em></h1>
                <p className="admin-login-copy">Sign in to manage your artworks and site content.</p>
                <form className="admin-form" onSubmit={submit}>
                    <label className="admin-field">
                        Email address
                        <input
                            autoComplete="username"
                            autoFocus
                            name="email"
                            onChange={(event) => form.setData('email', event.target.value)}
                            type="email"
                            value={form.data.email}
                        />
                        {form.errors.email && <span className="admin-error">{form.errors.email}</span>}
                    </label>
                    <label className="admin-field">
                        Password
                        <input
                            autoComplete="current-password"
                            name="password"
                            onChange={(event) => form.setData('password', event.target.value)}
                            type="password"
                            value={form.data.password}
                        />
                        {form.errors.password && <span className="admin-error">{form.errors.password}</span>}
                    </label>
                    <button className="admin-button admin-button--primary" disabled={form.processing} type="submit">
                        {form.processing ? 'Signing in…' : 'Sign in to your studio'}
                    </button>
                </form>
                <Link className="admin-back-link" href="/">← Back to AK PALETTES</Link>
            </section>
        </main>
    );
}
