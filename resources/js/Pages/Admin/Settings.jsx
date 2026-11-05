import { useForm } from '@inertiajs/react';
import AdminLayout from './AdminLayout';

const contentFields = [
    ['home_intro_heading', 'Homepage introduction heading', 3],
    ['home_intro_copy', 'Homepage introduction copy', 3],
    ['home_story_first', 'Homepage studio story — paragraph one', 4],
    ['home_story_second', 'Homepage studio story — paragraph two', 4],
    ['about_biography', 'Artist page — biography', 5],
    ['about_influences', 'Artist page — influences', 5],
    ['about_colour', 'Artist page — colour and process', 4],
];

export default function Settings({ settings }) {
    const form = useForm(settings);

    function submit(event) {
        event.preventDefault();
        form.put('/admin/settings');
    }

    return (
        <AdminLayout title="Site settings">
            <div className="admin-page-heading">
                <div>
                    <p className="admin-eyebrow">YOUR PUBLIC SITE</p>
                    <h1>Site settings</h1>
                    <p>Keep your artist story and contact details up to date.</p>
                </div>
            </div>

            <form className="admin-panel admin-settings-form" onSubmit={submit}>
                <div className="admin-form-section">
                    <p className="admin-eyebrow">ARTIST STORY</p>
                    <h2>Words visitors will see</h2>
                    <div className="admin-settings-grid">
                        {contentFields.map(([key, label, rows]) => (
                            <label className="admin-field" key={key}>
                                {label}
                                <textarea maxLength="5000" onChange={(event) => form.setData(key, event.target.value)} rows={rows} value={form.data[key] ?? ''} />
                                {form.errors[key] && <span className="admin-error">{form.errors[key]}</span>}
                            </label>
                        ))}
                    </div>
                </div>

                <div className="admin-form-section">
                    <p className="admin-eyebrow">CONTACT</p>
                    <h2>How people can reach you</h2>
                    <div className="admin-form-grid">
                        <label className="admin-field">
                            Contact email
                            <input autoComplete="email" onChange={(event) => form.setData('contact_email', event.target.value)} type="email" value={form.data.contact_email ?? ''} />
                            {form.errors.contact_email && <span className="admin-error">{form.errors.contact_email}</span>}
                        </label>
                        <label className="admin-field">
                            WhatsApp number
                            <input autoComplete="tel" onChange={(event) => form.setData('whatsapp_number', event.target.value)} placeholder="+254 700 000 000" value={form.data.whatsapp_number ?? ''} />
                            <small>Include your country code. Leave blank to hide WhatsApp links.</small>
                            {form.errors.whatsapp_number && <span className="admin-error">{form.errors.whatsapp_number}</span>}
                        </label>
                    </div>
                </div>

                <div className="admin-form-section">
                    <p className="admin-eyebrow">SOCIAL PROOF</p>
                    <h2>Show visitors that others love your work</h2>
                    <p className="admin-hint">Each part appears on the homepage only once you fill it in.</p>
                    <div className="admin-form-grid">
                        <label className="admin-field">
                            Instagram handle
                            <input onChange={(event) => form.setData('instagram_handle', event.target.value)} placeholder="@akpalettes" value={form.data.instagram_handle ?? ''} />
                            {form.errors.instagram_handle && <span className="admin-error">{form.errors.instagram_handle}</span>}
                        </label>
                    </div>
                    <label className="admin-field">
                        Collector quote
                        <textarea maxLength="600" onChange={(event) => form.setData('testimonial_quote', event.target.value)} rows="3" value={form.data.testimonial_quote ?? ''} />
                        <small>Use a real quote, with the collector’s permission.</small>
                        {form.errors.testimonial_quote && <span className="admin-error">{form.errors.testimonial_quote}</span>}
                    </label>
                    <div className="admin-form-grid">
                        <label className="admin-field">
                            Collector name
                            <input maxLength="120" onChange={(event) => form.setData('testimonial_author', event.target.value)} value={form.data.testimonial_author ?? ''} />
                            {form.errors.testimonial_author && <span className="admin-error">{form.errors.testimonial_author}</span>}
                        </label>
                        <label className="admin-field">
                            About the collector (optional)
                            <input maxLength="120" onChange={(event) => form.setData('testimonial_detail', event.target.value)} placeholder="Collector, Nairobi" value={form.data.testimonial_detail ?? ''} />
                            {form.errors.testimonial_detail && <span className="admin-error">{form.errors.testimonial_detail}</span>}
                        </label>
                    </div>
                    <label className="admin-field">
                        Exhibitions
                        <textarea maxLength="3000" onChange={(event) => form.setData('exhibitions', event.target.value)} placeholder={'2025 — Group show, Venue name, City\n2024 — Another exhibition, City'} rows="4" value={form.data.exhibitions ?? ''} />
                        <small>One per line. Start with the year, then a dash.</small>
                        {form.errors.exhibitions && <span className="admin-error">{form.errors.exhibitions}</span>}
                    </label>
                </div>

                <div className="admin-form-actions">
                    <button className="admin-button admin-button--primary" disabled={form.processing} type="submit">
                        {form.processing ? 'Saving…' : 'Save site settings'}
                    </button>
                </div>
            </form>
        </AdminLayout>
    );
}
