import { Head, Link, useForm, usePage } from '@inertiajs/react';

const navigation = [
    { label: 'Overview', href: '/admin' },
    { label: 'Artworks', href: '/admin/artworks' },
    { label: 'Site settings', href: '/admin/settings' },
];

export default function AdminLayout({ title, children }) {
    const page = usePage();
    const { url } = page;
    const { flash } = page.props;
    const logout = useForm({});

    return (
        <div className="admin-shell">
            <Head title={`${title} — AK PALETTES Admin`} />
            <aside className="admin-sidebar">
                <Link className="admin-brand" href="/admin">
                    <span className="wordmark-mark">AK</span>
                    <span><strong>PALETTES</strong><small>STUDIO ADMIN</small></span>
                </Link>
                <nav aria-label="Admin navigation">
                    {navigation.map((item) => {
                        const active = item.href === '/admin'
                            ? url === item.href
                            : url.startsWith(item.href);

                        return (
                            <Link
                                aria-current={active ? 'page' : undefined}
                                className={active ? 'admin-nav-link is-active' : 'admin-nav-link'}
                                href={item.href}
                                key={item.href}
                            >
                                <span aria-hidden="true">{item.label === 'Overview' ? '⌂' : item.label === 'Artworks' ? '▧' : '⚙'}</span>
                                {item.label}
                            </Link>
                        );
                    })}
                </nav>
                <div className="admin-sidebar-footer">
                    <Link href="/" className="admin-view-site">View public site ↗</Link>
                    <button
                        className="admin-logout"
                        disabled={logout.processing}
                        onClick={() => logout.post('/admin/logout')}
                        type="button"
                    >
                        Sign out
                    </button>
                </div>
            </aside>

            <main className="admin-main">
                <header className="admin-topbar">
                    <span>AK PALETTES <span aria-hidden="true">/</span> Admin</span>
                    <span className="admin-status"><i /> Studio workspace</span>
                </header>
                <div className="admin-content">
                    {flash?.success && <div className="admin-flash" role="status">{flash.success}</div>}
                    {children}
                </div>
            </main>
        </div>
    );
}
