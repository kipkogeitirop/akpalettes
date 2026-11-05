import { Head, Link, usePage } from '@inertiajs/react';
import ArrowIcon from '../Components/ArrowIcon';
import ArtworkCard from '../Components/ArtworkCard';
import ContactBand from '../Components/ContactBand';
import HeroSlideshow from '../Components/HeroSlideshow';
import SiteLayout from '../Components/SiteLayout';
import useContact from '../Components/useContact';
import WhatsAppIcon from '../Components/WhatsAppIcon';

const commissionSteps = [
    {
        title: 'The brief',
        text: 'Tell me the story — a person, a place, a memory or a feeling — along with the size and colours you have in mind.',
    },
    {
        title: 'The sketch',
        text: 'I share a sketch and a colour direction so we can shape the idea together before any paint touches the canvas.',
    },
    {
        title: 'The painting',
        text: 'The piece comes to life layer by layer. I’ll share progress along the way so you can watch your story take form.',
    },
    {
        title: 'The delivery',
        text: 'Once it’s finished and dry, your painting is carefully packed and sent home to you, ready to hang.',
    },
];

function parseExhibitions(text) {
    return text
        .split('\n')
        .map((line) => line.trim())
        .filter(Boolean)
        .map((line) => {
            const [year, ...rest] = line.split(/\s+[—–-]\s+/);

            return rest.length > 0 ? { year, title: rest.join(' — ') } : { year: '', title: line };
        });
}

export default function Welcome({ hero, featured }) {
    const { siteContent } = usePage().props;
    const { hasWhatsApp, whatsappUrl } = useContact();
    const instagramHandle = siteContent.instagram_handle?.replace(/^@/, '');
    const exhibitions = parseExhibitions(siteContent.exhibitions ?? '');
    const hasTestimonial = Boolean(siteContent.testimonial_quote);
    const hasSocialProof = hasTestimonial || exhibitions.length > 0 || Boolean(instagramHandle);
    const instagramPreview = [...hero, ...featured]
        .filter((artwork, index, all) => all.findIndex((other) => other.slug === artwork.slug) === index)
        .slice(0, 6);

    return (
        <SiteLayout>
            <Head title="AK PALETTES — Where colours become stories">
                <meta
                    name="description"
                    content="Explore the art of Aloknanda Kundu: contemporary paintings inspired by Indian traditions, African cultures, nature and the stories that connect us."
                />
            </Head>

            <section className="hero">
                <div className="hero-copy">
                    <p className="eyebrow"><span /> Art by Aloknanda Kundu</p>
                    <h1>Where colours<br />become <em>stories.</em></h1>
                    <p className="hero-intro">
                        A meeting of cultures, memories and imagination — expressed one brushstroke at a time.
                    </p>
                    <Link className="text-link" href="/gallery">
                        Explore the collection <ArrowIcon />
                    </Link>
                    <div className="hero-note">
                        <span className="note-line" />
                        <span>Rooted in tradition. Made for today.</span>
                    </div>
                </div>
                {hero.length > 0 && <HeroSlideshow artworks={hero} />}
            </section>

            <section className="intro-section">
                <div className="section-kicker">
                    <span className="section-number">01</span>
                    <span>Meet the artist</span>
                </div>
                <div className="intro-content">
                    <h2>{siteContent.home_intro_heading}</h2>
                    <div className="intro-aside">
                        <img
                            className="intro-portrait"
                            src="/images/aloknanda-kundu-sm.jpg"
                            alt="Aloknanda Kundu"
                            width="320"
                            height="320"
                            loading="lazy"
                        />
                        <p>{siteContent.home_intro_copy}</p>
                        <Link className="text-link" href="/about">
                            A little more about me <ArrowIcon />
                        </Link>
                    </div>
                </div>
                <div className="intro-rule" />
                <div className="influence-list" aria-label="Artistic influences">
                    <span>Indian traditions</span>
                    <span className="influence-dot">✳</span>
                    <span>African cultures</span>
                    <span className="influence-dot">✳</span>
                    <span>Nature &amp; memory</span>
                    <span className="influence-dot">✳</span>
                    <span>Contemporary spirit</span>
                </div>
            </section>

            <section className="work-section">
                <div className="work-heading">
                    <div>
                        <div className="section-kicker section-kicker--light">
                            <span className="section-number">02</span>
                            <span>A world in colour</span>
                        </div>
                        <h2>Selected <em>explorations.</em></h2>
                    </div>
                    <p>Every canvas begins with a feeling.<br />Here are a few places it has taken me.</p>
                </div>
                <div className="artwork-grid artwork-grid--featured">
                    {featured.map((artwork, index) => (
                        <ArtworkCard artwork={artwork} index={index} key={artwork.slug} />
                    ))}
                </div>
                <div className="work-footnote">
                    <span>Colour has a language of its own.</span>
                    <Link href="/gallery">View the full gallery <b>↗</b></Link>
                </div>
            </section>

            <section className="commission-section">
                <div className="work-heading">
                    <div>
                        <div className="section-kicker">
                            <span className="section-number">03</span>
                            <span>Commissions</span>
                        </div>
                        <h2>Your story, <em>in my colours.</em></h2>
                    </div>
                    <p>A painting made just for you —<br />here’s how it comes together.</p>
                </div>
                <ol className="commission-steps">
                    {commissionSteps.map((step, index) => (
                        <li key={step.title}>
                            <span className="process-number">0{index + 1}</span>
                            <h3>{step.title}</h3>
                            <p>{step.text}</p>
                        </li>
                    ))}
                </ol>
                <div className="commission-actions">
                    {hasWhatsApp && (
                        <a
                            className="button button--whatsapp"
                            href={whatsappUrl('Hi Aloknanda, I’d love to talk about commissioning a painting.')}
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            <WhatsAppIcon /> Start a commission
                        </a>
                    )}
                    <Link className="button button--outline" href="/contact">
                        Ask a question <ArrowIcon />
                    </Link>
                </div>
            </section>

            <section className="story-section">
                <div className="story-image">
                    <img
                        src="/images/artworks/the-tree-of-life.jpg"
                        alt="A tree with a deer and a woman’s face woven into its trunk, painted in blue, green and orange on white"
                        width="940"
                        height="1235"
                        loading="lazy"
                    />
                    <div className="story-image-label">From the easel <span>✳</span></div>
                </div>
                <div className="story-copy">
                    <div className="section-kicker">
                        <span className="section-number">04</span>
                        <span>The story behind the name</span>
                    </div>
                    <h2>A name, a palette,<br />a <em>journey.</em></h2>
                    <p>
                        {siteContent.home_story_first}
                    </p>
                    <p>{siteContent.home_story_second}
                    </p>
                    <Link className="text-link" href="/about">
                        Read my story <ArrowIcon />
                    </Link>
                </div>
            </section>

            {hasSocialProof && (
                <section className="proof-section">
                    {(hasTestimonial || exhibitions.length > 0) && (
                        <div className={hasTestimonial && exhibitions.length > 0 ? 'proof-layout' : 'proof-layout proof-layout--single'}>
                            {hasTestimonial && (
                                <figure className="proof-quote">
                                    <span className="closing-star">✳</span>
                                    <blockquote>“{siteContent.testimonial_quote}”</blockquote>
                                    <figcaption>
                                        <strong>{siteContent.testimonial_author}</strong>
                                        {siteContent.testimonial_detail && <span>{siteContent.testimonial_detail}</span>}
                                    </figcaption>
                                </figure>
                            )}
                            {exhibitions.length > 0 && (
                                <div className="proof-exhibitions">
                                    <div className="section-kicker">
                                        <span className="section-number">✳</span>
                                        <span>Exhibitions</span>
                                    </div>
                                    <ul>
                                        {exhibitions.map((exhibition) => (
                                            <li key={`${exhibition.year}-${exhibition.title}`}>
                                                <span>{exhibition.year}</span>
                                                <span>{exhibition.title}</span>
                                            </li>
                                        ))}
                                    </ul>
                                </div>
                            )}
                        </div>
                    )}

                    {instagramHandle && (
                        <div className="instagram-strip">
                            <div className="instagram-strip-heading">
                                <div className="section-kicker">
                                    <span className="section-number">✳</span>
                                    <span>Follow along</span>
                                </div>
                                <a className="text-link" href={`https://www.instagram.com/${instagramHandle}/`} target="_blank" rel="noopener noreferrer">
                                    @{instagramHandle} on Instagram <ArrowIcon diagonal />
                                </a>
                            </div>
                            <div className="instagram-grid">
                                {instagramPreview.map((artwork) => (
                                    <a
                                        href={`https://www.instagram.com/${instagramHandle}/`}
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        aria-label={`${artwork.title} — see more on Instagram`}
                                        key={artwork.slug}
                                    >
                                        <img src={artwork.thumbnail} alt="" loading="lazy" />
                                    </a>
                                ))}
                            </div>
                        </div>
                    )}
                </section>
            )}

            <ContactBand />
        </SiteLayout>
    );
}
