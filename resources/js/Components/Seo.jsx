import { Head } from '@inertiajs/react';

/**
 * Keeps the server-rendered title, meta tags and structured data in sync while
 * visitors move between pages. The `head-key` values match the `data-inertia`
 * attributes in resources/views/app.blade.php.
 */
export default function Seo({ seo }) {
    if (!seo) {
        return null;
    }

    return (
        <Head>
            <title>{seo.title}</title>
            <meta head-key="description" name="description" content={seo.description} />
            <meta head-key="robots" name="robots" content="index, follow, max-image-preview:large" />
            <link head-key="canonical" rel="canonical" href={seo.canonical} />
            <meta head-key="og:site_name" property="og:site_name" content={seo.siteName} />
            <meta head-key="og:type" property="og:type" content={seo.type} />
            <meta head-key="og:title" property="og:title" content={seo.title} />
            <meta head-key="og:description" property="og:description" content={seo.description} />
            <meta head-key="og:url" property="og:url" content={seo.canonical} />
            <meta head-key="og:image" property="og:image" content={seo.image} />
            <meta head-key="og:image:alt" property="og:image:alt" content={seo.imageAlt} />
            <meta head-key="twitter:card" name="twitter:card" content="summary_large_image" />
            <meta head-key="twitter:title" name="twitter:title" content={seo.title} />
            <meta head-key="twitter:description" name="twitter:description" content={seo.description} />
            <meta head-key="twitter:image" name="twitter:image" content={seo.image} />
            <script
                head-key="schema"
                type="application/ld+json"
                dangerouslySetInnerHTML={{ __html: JSON.stringify(seo.schema).replace(/</g, '\\u003c') }}
            />
        </Head>
    );
}
