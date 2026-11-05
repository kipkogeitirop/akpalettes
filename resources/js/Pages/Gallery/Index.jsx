import { Head } from '@inertiajs/react';
import { useState } from 'react';
import ArtworkCard from '../../Components/ArtworkCard';
import ContactBand from '../../Components/ContactBand';
import SiteLayout from '../../Components/SiteLayout';

export default function GalleryIndex({ artworks, categories }) {
    const [activeFilter, setActiveFilter] = useState('All work');
    const [availableOnly, setAvailableOnly] = useState(false);
    const filters = ['All work', ...categories];
    const availableCount = artworks.filter((artwork) => artwork.availability === 'available').length;
    const visibleArtworks = artworks.filter(
        (artwork) => (activeFilter === 'All work' || artwork.category === activeFilter)
            && (!availableOnly || artwork.availability === 'available'),
    );

    return (
        <SiteLayout>
            <Head title="Gallery — AK PALETTES">
                <meta
                    name="description"
                    content="The full collection of paintings by Aloknanda Kundu, inspired by Indian traditions, nature, African cultures and contemporary life."
                />
            </Head>

            <section className="work-section work-section--page">
                <div className="work-heading">
                    <div>
                        <div className="section-kicker section-kicker--light">
                            <span className="section-number">✳</span>
                            <span>The gallery</span>
                        </div>
                        <h1>Every canvas, <em>a story.</em></h1>
                    </div>
                    <p>
                        Devotional murals, folk traditions, quiet landscapes<br />and bold new faces — {artworks.length} works and counting.
                    </p>
                </div>
                <div className="filter-list" aria-label="Filter artworks">
                    {filters.map((filter) => (
                        <button
                            className={activeFilter === filter ? 'filter-button is-active' : 'filter-button'}
                            key={filter}
                            type="button"
                            aria-pressed={activeFilter === filter}
                            onClick={() => setActiveFilter(filter)}
                        >
                            {filter}
                            <span className="filter-count">
                                {filter === 'All work' ? artworks.length : artworks.filter((artwork) => artwork.category === filter).length}
                            </span>
                        </button>
                    ))}
                    {availableCount > 0 && (
                        <button
                            className={availableOnly ? 'filter-button filter-button--available is-active' : 'filter-button filter-button--available'}
                            type="button"
                            aria-pressed={availableOnly}
                            onClick={() => setAvailableOnly(!availableOnly)}
                        >
                            Available to buy
                            <span className="filter-count">{availableCount}</span>
                        </button>
                    )}
                </div>
                <div className="artwork-grid">
                    {visibleArtworks.map((artwork, index) => (
                        <ArtworkCard artwork={artwork} index={index} key={artwork.slug} />
                    ))}
                    {visibleArtworks.length === 0 && (
                        <p className="empty-filter">Nothing available in this category right now — ask me about a commission.</p>
                    )}
                </div>
                <div className="work-footnote">
                    <span>Colour has a language of its own.</span>
                    <span>Keep looking, keep feeling <b>↗</b></span>
                </div>
            </section>

            <ContactBand
                title={<>Seen something you <em>love?</em></>}
                text="Ask about any piece, or tell me about a painting you’d like made just for you."
                message="Hi Aloknanda, I’ve been looking through your gallery and would love to ask about a piece."
            />
        </SiteLayout>
    );
}
