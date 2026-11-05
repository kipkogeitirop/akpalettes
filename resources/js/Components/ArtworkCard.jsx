import { Link } from '@inertiajs/react';
import ArrowIcon from './ArrowIcon';
import AvailabilityBadge from './AvailabilityBadge';

function shapeFor(artwork) {
    const ratio = artwork.height / artwork.width;

    if (ratio >= 1.4) {
        return 'artwork-card--portrait';
    }

    return ratio < 1.1 ? 'artwork-card--square' : 'artwork-card--landscape';
}

export default function ArtworkCard({ artwork, index }) {
    return (
        <article className={`artwork-card ${shapeFor(artwork)}`}>
            <Link href={`/gallery/${artwork.slug}`} aria-label={`View ${artwork.title}`}>
                <div className="artwork-image">
                    <img src={artwork.thumbnail} alt={artwork.alt} width={artwork.width} height={artwork.height} loading="lazy" />
                    <span className="artwork-number">{String(index + 1).padStart(2, '0')}</span>
                    <AvailabilityBadge artwork={artwork} className="artwork-availability" />
                    <span className="artwork-arrow"><ArrowIcon diagonal /></span>
                </div>
                <div className="artwork-caption">
                    <h3>{artwork.title}</h3>
                    <span>{artwork.category}</span>
                </div>
            </Link>
        </article>
    );
}
