import { Link } from '@inertiajs/react';
import { useEffect, useState } from 'react';

const slideDuration = 6000;

export default function HeroSlideshow({ artworks }) {
    const [activeIndex, setActiveIndex] = useState(0);
    const [paused, setPaused] = useState(false);
    const activeArtwork = artworks[activeIndex];

    useEffect(() => {
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        if (artworks.length < 2 || paused || prefersReducedMotion) {
            return undefined;
        }

        const timer = window.setTimeout(() => setActiveIndex((activeIndex + 1) % artworks.length), slideDuration);

        return () => window.clearTimeout(timer);
    }, [activeIndex, artworks.length, paused]);

    return (
        <div
            className="hero-art"
            onMouseEnter={() => setPaused(true)}
            onMouseLeave={() => setPaused(false)}
            onFocus={() => setPaused(true)}
            onBlur={() => setPaused(false)}
        >
            <Link className="hero-art-frame" href={`/gallery/${activeArtwork.slug}`} aria-label={`View ${activeArtwork.title}`}>
                {artworks.map((artwork, index) => (
                    <img
                        className={index === activeIndex ? 'hero-slide is-active' : 'hero-slide'}
                        src={artwork.image}
                        alt={index === activeIndex ? artwork.alt : ''}
                        aria-hidden={index !== activeIndex}
                        width={artwork.width}
                        height={artwork.height}
                        fetchPriority={index === 0 ? 'high' : 'low'}
                        key={artwork.slug}
                    />
                ))}
            </Link>
            <span className="hero-stamp">AK<br /><small>✳</small><br />ART</span>
            <span className="hero-caption" aria-live="polite">{activeArtwork.title}</span>
            {artworks.length > 1 && (
                <div className="hero-dots" role="group" aria-label="Choose a painting">
                    {artworks.map((artwork, index) => (
                        <button
                            className={index === activeIndex ? 'is-active' : undefined}
                            type="button"
                            aria-label={`Show ${artwork.title}`}
                            aria-pressed={index === activeIndex}
                            onClick={() => setActiveIndex(index)}
                            key={artwork.slug}
                        />
                    ))}
                </div>
            )}
        </div>
    );
}
