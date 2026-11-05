import { Link } from '@inertiajs/react';
import AdminLayout from './AdminLayout';

export default function Dashboard({ stats, recentArtworks }) {
    return (
        <AdminLayout title="Overview">
            <div className="admin-page-heading">
                <div>
                    <p className="admin-eyebrow">YOUR CREATIVE SPACE</p>
                    <h1>Good to see you.</h1>
                    <p>Here’s what’s happening with your collection.</p>
                </div>
                <Link className="admin-button admin-button--primary" href="/admin/artworks/create">＋ Add artwork</Link>
            </div>

            <section className="admin-stats" aria-label="Collection overview">
                <article><span>Total artworks</span><strong>{stats.total}</strong><small>pieces in your collection</small></article>
                <article><span>Published</span><strong>{stats.published}</strong><small>visible in the gallery</small></article>
                <article><span>Drafts</span><strong>{stats.drafts}</strong><small>still in the studio</small></article>
                <article><span>Featured</span><strong>{stats.featured}</strong><small>highlighted on your site</small></article>
            </section>

            <section className="admin-panel">
                <div className="admin-panel-heading">
                    <div><p className="admin-eyebrow">RECENTLY UPDATED</p><h2>Your artworks</h2></div>
                    <Link className="admin-text-link" href="/admin/artworks">View all →</Link>
                </div>
                {recentArtworks.length > 0 ? (
                    <div className="admin-recent-list">
                        {recentArtworks.map((artwork) => (
                            <div className="admin-recent-item" key={artwork.id}>
                                <span className="admin-artwork-monogram" aria-hidden="true">AK</span>
                                <span className="admin-recent-title"><strong>{artwork.title}</strong><small>{artwork.category}</small></span>
                                <span className={artwork.is_published ? 'admin-pill is-published' : 'admin-pill'}>{artwork.is_published ? 'Published' : 'Draft'}</span>
                                <Link aria-label={`Edit ${artwork.title}`} className="admin-row-link" href={`/admin/artworks/${artwork.id}/edit`}>Edit ↗</Link>
                            </div>
                        ))}
                    </div>
                ) : (
                    <div className="admin-empty">
                        <p>Your collection is ready for its first artwork.</p>
                        <Link className="admin-text-link" href="/admin/artworks/create">Add your first piece →</Link>
                    </div>
                )}
            </section>

            <section className="admin-quick-links">
                <Link href="/admin/artworks"><span>▧</span><strong>Manage the gallery</strong><small>Add, edit or arrange your artworks</small></Link>
                <Link href="/admin/settings"><span>⚙</span><strong>Update site content</strong><small>Edit your story and contact details</small></Link>
                <Link href="/gallery" target="_blank"><span>↗</span><strong>See your public site</strong><small>Preview the gallery as visitors see it</small></Link>
            </section>
        </AdminLayout>
    );
}
