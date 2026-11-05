import { Link } from '@inertiajs/react';
import ArrowIcon from '../../Components/ArrowIcon';
import ArtworkCard from '../../Components/ArtworkCard';
import AvailabilityBadge from '../../Components/AvailabilityBadge';
import Seo from '../../Components/Seo';
import SiteLayout from '../../Components/SiteLayout';
import useContact from '../../Components/useContact';
import WhatsAppIcon from '../../Components/WhatsAppIcon';

export default function GalleryShow({ artwork, position, total, previous, next, related, seo }) {
    const { email, hasWhatsApp, whatsappUrl } = useContact();
    const isSold = artwork.availability === 'sold';
    const enquiry = isSold
        ? `Hi Aloknanda, I love your painting “${artwork.title}”. I see it has sold — could you create something similar for me?`
        : `Hi Aloknanda, I’m interested in your painting “${artwork.title}”. Could you tell me more about it?`;
    const details = [
        ['Medium', artwork.medium],
        ['Size', artwork.dimensions],
    ].filter(([, value]) => value);

    return (
        <SiteLayout>
            <Seo seo={seo} />

            <section className="artwork-detail">
                <Link className="back-link" href="/gallery">
                    <ArrowIcon back /> Back to the gallery
                </Link>

                <div className="artwork-detail-layout">
                    <figure className="artwork-detail-image">
                        <img src={artwork.image} alt={artwork.alt} width={artwork.width} height={artwork.height} />
                    </figure>

                    <div className="artwork-detail-copy">
                        <div className="section-kicker">
                            <span className="section-number">{String(position).padStart(2, '0')}</span>
                            <span>of {total} — {artwork.category}</span>
                        </div>
                        <h1>{artwork.title}</h1>
                        <AvailabilityBadge artwork={artwork} />
                        <p>{artwork.description}</p>

                        {details.length > 0 && (
                            <dl className="artwork-facts">
                                {details.map(([label, value]) => (
                                    <div key={label}>
                                        <dt>{label}</dt>
                                        <dd>{value}</dd>
                                    </div>
                                ))}
                            </dl>
                        )}

                        <div className="artwork-enquiry">
                            <span>
                                {isSold
                                    ? 'This piece has found its home — but I’d love to paint something like it for you.'
                                    : 'Interested in this piece, or something like it?'}
                            </span>
                            {hasWhatsApp && (
                                <a className="button button--whatsapp" href={whatsappUrl(enquiry)} target="_blank" rel="noopener noreferrer">
                                    <WhatsAppIcon /> {isSold ? 'Ask about a commission' : 'Enquire on WhatsApp'}
                                </a>
                            )}
                            <a
                                className="button button--outline"
                                href={`mailto:${email}?subject=${encodeURIComponent(`Enquiry: ${artwork.title}`)}&body=${encodeURIComponent(enquiry)}`}
                            >
                                Enquire by email <ArrowIcon />
                            </a>
                        </div>

                        <nav className="artwork-pager" aria-label="More artworks">
                            <Link href={`/gallery/${previous.slug}`}>
                                <ArrowIcon back />
                                <span><small>Previous</small>{previous.title}</span>
                            </Link>
                            <Link href={`/gallery/${next.slug}`}>
                                <span><small>Next</small>{next.title}</span>
                                <ArrowIcon />
                            </Link>
                        </nav>
                    </div>
                </div>
            </section>

            <section className="work-section">
                <div className="work-heading">
                    <div>
                        <div className="section-kicker section-kicker--light">
                            <span className="section-number">✳</span>
                            <span>Keep exploring</span>
                        </div>
                        <h2>More to <em>discover.</em></h2>
                    </div>
                    <Link className="text-link text-link--light" href="/gallery">
                        View the full gallery <ArrowIcon />
                    </Link>
                </div>
                <div className="artwork-grid artwork-grid--featured">
                    {related.map((relatedArtwork, index) => (
                        <ArtworkCard artwork={relatedArtwork} index={index} key={relatedArtwork.slug} />
                    ))}
                </div>
            </section>
        </SiteLayout>
    );
}
