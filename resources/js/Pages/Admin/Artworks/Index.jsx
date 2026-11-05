import { Link, router } from '@inertiajs/react';
import AdminLayout from '../AdminLayout';

export default function ArtworkIndex({ artworks }) {
    function removeArtwork(artwork) {
        if (window.confirm(`Remove “${artwork.title}” from your collection?`)) {
            router.delete(`/admin/artworks/${artwork.id}`);
        }
    }

    return (
        <AdminLayout title="Artworks">
            <div className="admin-page-heading">
                <div>
                    <p className="admin-eyebrow">THE COLLECTION</p>
                    <h1>Your artworks</h1>
                    <p>Curate the pieces visitors see in your gallery.</p>
                </div>
                <Link className="admin-button admin-button--primary" href="/admin/artworks/create">＋ Add artwork</Link>
            </div>

            <section className="admin-panel admin-artwork-panel">
                <div className="admin-panel-heading">
                    <div><p className="admin-eyebrow">ALL PIECES</p><h2>{artworks.length} artworks</h2></div>
                    <Link className="admin-text-link" href="/gallery" target="_blank">Preview gallery ↗</Link>
                </div>
                {artworks.length > 0 ? (
                    <div className="admin-artwork-list">
                        {artworks.map((artwork) => (
                            <article className="admin-artwork-row" key={artwork.id}>
                                <div className="admin-artwork-thumb"><img alt="" src={artwork.image_url} /></div>
                                <div className="admin-artwork-info">
                                    <h3>{artwork.title}</h3>
                                    <p>{artwork.category} <span>·</span> {artwork.slug}</p>
                                </div>
                                <div className="admin-artwork-badges">
                                    {artwork.in_hero && <span className="admin-pill is-featured">Hero</span>}
                                    {artwork.featured && <span className="admin-pill is-featured">Featured</span>}
                                    {artwork.availability_label && <span className="admin-pill">{artwork.availability_label}</span>}
                                    <span className={artwork.is_published ? 'admin-pill is-published' : 'admin-pill'}>{artwork.is_published ? 'Published' : 'Draft'}</span>
                                </div>
                                <div className="admin-artwork-actions">
                                    <Link className="admin-row-link" href={`/admin/artworks/${artwork.id}/edit`}>Edit</Link>
                                    <button className="admin-delete-button" onClick={() => removeArtwork(artwork)} type="button">Remove</button>
                                </div>
                            </article>
                        ))}
                    </div>
                ) : (
                    <div className="admin-empty">
                        <p>No artworks yet. Add your first piece to start building the collection.</p>
                        <Link className="admin-text-link" href="/admin/artworks/create">Add artwork →</Link>
                    </div>
                )}
            </section>
        </AdminLayout>
    );
}
