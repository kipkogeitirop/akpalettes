export default function AvailabilityBadge({ artwork, className = '' }) {
    if (!artwork.availability) {
        return null;
    }

    return (
        <span className={`availability-badge availability-badge--${artwork.availability} ${className}`.trim()}>
            <i aria-hidden="true" /> {artwork.availability_label}
        </span>
    );
}
