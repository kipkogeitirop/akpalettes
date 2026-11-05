import { Link, useForm } from '@inertiajs/react';
import AdminLayout from '../AdminLayout';

export default function ArtworkForm({ artwork, categories, availabilities }) {
    const form = useForm({
        title: artwork?.title ?? '',
        slug: artwork?.slug ?? '',
        category: artwork?.category ?? categories[0],
        availability: artwork?.availability ?? '',
        medium: artwork?.medium ?? '',
        dimensions: artwork?.dimensions ?? '',
        alt: artwork?.alt ?? '',
        description: artwork?.description ?? '',
        image: null,
        featured: artwork?.featured ?? false,
        in_hero: artwork?.in_hero ?? false,
        is_published: artwork?.is_published ?? true,
        sort_order: artwork?.sort_order ?? 0,
    });

    function submit(event) {
        event.preventDefault();

        if (artwork) {
            form.transform((data) => ({ ...data, _method: 'put' }))
                .post(`/admin/artworks/${artwork.id}`, { forceFormData: true });
        } else {
            form.post('/admin/artworks', { forceFormData: true });
        }
    }

    return (
        <AdminLayout title={artwork ? 'Edit artwork' : 'Add artwork'}>
            <div className="admin-page-heading">
                <div>
                    <p className="admin-eyebrow">THE COLLECTION</p>
                    <h1>{artwork ? 'Edit artwork' : 'Add a new artwork'}</h1>
                    <p>Give this piece its place in your story.</p>
                </div>
                <Link className="admin-button admin-button--quiet" href="/admin/artworks">← Back to artworks</Link>
            </div>

            <form className="admin-panel admin-edit-form" onSubmit={submit}>
                <div className="admin-form-section">
                    <p className="admin-eyebrow">ARTWORK DETAILS</p>
                    <div className="admin-form-grid">
                        <label className="admin-field">
                            Title
                            <input maxLength="255" onChange={(event) => form.setData('title', event.target.value)} value={form.data.title} />
                            {form.errors.title && <span className="admin-error">{form.errors.title}</span>}
                        </label>
                        <label className="admin-field">
                            URL slug
                            <input maxLength="160" onChange={(event) => form.setData('slug', event.target.value)} value={form.data.slug} />
                            <small>Lowercase letters, numbers and hyphens.</small>
                            {form.errors.slug && <span className="admin-error">{form.errors.slug}</span>}
                        </label>
                        <label className="admin-field">
                            Category
                            <select onChange={(event) => form.setData('category', event.target.value)} value={form.data.category}>
                                {categories.map((category) => <option key={category} value={category}>{category}</option>)}
                            </select>
                            {form.errors.category && <span className="admin-error">{form.errors.category}</span>}
                        </label>
                        <label className="admin-field">
                            Display order
                            <input min="0" max="9999" onChange={(event) => form.setData('sort_order', event.target.value)} type="number" value={form.data.sort_order} />
                            <small>Lower numbers appear first.</small>
                            {form.errors.sort_order && <span className="admin-error">{form.errors.sort_order}</span>}
                        </label>
                    </div>
                    <label className="admin-field">
                        Image description (alt text)
                        <input maxLength="255" onChange={(event) => form.setData('alt', event.target.value)} value={form.data.alt} />
                        <small>Describe the visible artwork for visitors using screen readers.</small>
                        {form.errors.alt && <span className="admin-error">{form.errors.alt}</span>}
                    </label>
                    <label className="admin-field">
                        Story behind the piece
                        <textarea maxLength="5000" onChange={(event) => form.setData('description', event.target.value)} rows="5" value={form.data.description} />
                        {form.errors.description && <span className="admin-error">{form.errors.description}</span>}
                    </label>
                </div>

                <div className="admin-form-section">
                    <p className="admin-eyebrow">FOR COLLECTORS</p>
                    <div className="admin-form-grid">
                        <label className="admin-field">
                            Availability
                            <select onChange={(event) => form.setData('availability', event.target.value)} value={form.data.availability}>
                                <option value="">Don’t show</option>
                                {availabilities.map((option) => <option key={option.value} value={option.value}>{option.label}</option>)}
                            </select>
                            <small>Shown as a label on the gallery and artwork page.</small>
                            {form.errors.availability && <span className="admin-error">{form.errors.availability}</span>}
                        </label>
                        <label className="admin-field">
                            Medium
                            <input maxLength="120" onChange={(event) => form.setData('medium', event.target.value)} placeholder="Acrylic on canvas" value={form.data.medium} />
                            {form.errors.medium && <span className="admin-error">{form.errors.medium}</span>}
                        </label>
                        <label className="admin-field">
                            Size
                            <input maxLength="60" onChange={(event) => form.setData('dimensions', event.target.value)} placeholder="60 × 90 cm" value={form.data.dimensions} />
                            {form.errors.dimensions && <span className="admin-error">{form.errors.dimensions}</span>}
                        </label>
                    </div>
                </div>

                <div className="admin-form-section">
                    <p className="admin-eyebrow">ARTWORK IMAGE</p>
                    {artwork?.image_url && (
                        <div className="admin-current-image">
                            <img alt={artwork.alt} src={artwork.image_url} />
                            <span>Current artwork image</span>
                        </div>
                    )}
                    <label className="admin-field">
                        {artwork ? 'Replace image (optional)' : 'Choose an image'}
                        <input accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" onChange={(event) => form.setData('image', event.target.files[0] ?? null)} type="file" />
                        <small>JPG, PNG or WebP, up to 10 MB.</small>
                        {form.errors.image && <span className="admin-error">{form.errors.image}</span>}
                    </label>
                </div>

                <div className="admin-form-section">
                    <p className="admin-eyebrow">VISIBILITY</p>
                    <div className="admin-checkboxes">
                        <label><input checked={form.data.is_published} onChange={(event) => form.setData('is_published', event.target.checked)} type="checkbox" /> Publish in the public gallery</label>
                        <label><input checked={form.data.featured} onChange={(event) => form.setData('featured', event.target.checked)} type="checkbox" /> Feature on the homepage</label>
                        <label><input checked={form.data.in_hero} onChange={(event) => form.setData('in_hero', event.target.checked)} type="checkbox" /> Show in the homepage hero slideshow</label>
                    </div>
                    <small className="admin-hint">The hero rotates through up to four pieces, in display order.</small>
                    {form.errors.is_published && <span className="admin-error">{form.errors.is_published}</span>}
                    {form.errors.featured && <span className="admin-error">{form.errors.featured}</span>}
                    {form.errors.in_hero && <span className="admin-error">{form.errors.in_hero}</span>}
                </div>

                <div className="admin-form-actions">
                    <Link className="admin-button admin-button--quiet" href="/admin/artworks">Cancel</Link>
                    <button className="admin-button admin-button--primary" disabled={form.processing} type="submit">
                        {form.processing ? 'Saving…' : artwork ? 'Save changes' : 'Add artwork'}
                    </button>
                </div>
            </form>
        </AdminLayout>
    );
}
