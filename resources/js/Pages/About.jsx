import { Link, usePage } from '@inertiajs/react';
import ArrowIcon from '../Components/ArrowIcon';
import ContactBand from '../Components/ContactBand';
import Seo from '../Components/Seo';
import SiteLayout from '../Components/SiteLayout';

const influences = [
    {
        title: 'Indian traditions',
        slug: 'ardhanarishvara',
        alt: 'Detail of a mural-style painting of Ardhanarishvara',
        text: 'Mural, folk and devotional painting — the ornament, the borders, the gods and the everyday people they were painted for.',
    },
    {
        title: 'African cultures',
        slug: 'into-the-sun',
        alt: 'Detail of a painting of a woman walking toward a glowing sun',
        text: 'Warm earth tones, bold pattern and a celebration of grace and strength that speaks across continents.',
    },
    {
        title: 'Nature & memory',
        slug: 'the-stag-in-bloom',
        alt: 'Detail of a painting of a stag among wildflowers',
        text: 'Trees, birds, flowers and animals — the quiet details of the natural world, and the memories they hold.',
    },
    {
        title: 'Contemporary spirit',
        slug: 'two-faces-of-the-goddess',
        alt: 'Detail of a painting of two faces, one golden and one blue',
        text: 'Old stories, retold for today. Traditional ideas meet new colours, new faces and new ways of seeing.',
    },
];

const process = [
    {
        title: 'It begins with a feeling',
        text: 'A memory, a story, a face, a festival — something that stays with me long enough to ask to be painted.',
    },
    {
        title: 'Then comes the palette',
        text: 'I choose colours the way you’d choose words. Every palette sets the mood before a single line is drawn.',
    },
    {
        title: 'And it becomes a story',
        text: 'Line by line and layer by layer, the piece finds its own voice — often somewhere I never planned to go.',
    },
];

export default function About({ seo }) {
    const { siteContent } = usePage().props;

    return (
        <SiteLayout>
            <Seo seo={seo} />

            <section className="page-hero">
                <p className="eyebrow"><span /> The artist</p>
                <h1>Hello, I’m <em>Aloknanda.</em></h1>
                <p className="page-hero-intro">
                    An artist and painter drawn to the stories held in colour, culture and the world around us.
                </p>
            </section>

            <section className="story-section">
                <div className="story-image story-image--portrait">
                    <img
                        src="/images/aloknanda-kundu.jpg"
                        alt="Aloknanda Kundu smiling on a sunny beach, wearing sunglasses and a white top"
                        width="640"
                        height="768"
                    />
                    <div className="story-image-label">Aloknanda Kundu <span>✳</span></div>
                </div>
                <div className="story-copy">
                    <div className="section-kicker">
                        <span className="section-number">01</span>
                        <span>My story</span>
                    </div>
                    <h2>Art is how I make sense of the <em>world.</em></h2>
                    <p>{siteContent.about_biography}</p>
                    <p>{siteContent.about_influences}</p>
                    <p>{siteContent.about_colour}</p>
                </div>
            </section>

            <section className="influence-section">
                <div className="work-heading">
                    <div>
                        <div className="section-kicker">
                            <span className="section-number">02</span>
                            <span>What inspires me</span>
                        </div>
                        <h2>Four worlds, <em>one palette.</em></h2>
                    </div>
                    <p>The places, traditions and feelings<br />I keep coming back to.</p>
                </div>
                <div className="influence-grid">
                    {influences.map((influence) => (
                        <Link className="influence-card" href={`/gallery/${influence.slug}`} key={influence.title}>
                            <div className="influence-card-image">
                                <img src={`/images/artworks/${influence.slug}-sm.jpg`} alt={influence.alt} loading="lazy" />
                            </div>
                            <h3>{influence.title}</h3>
                            <p>{influence.text}</p>
                        </Link>
                    ))}
                </div>
            </section>

            <section className="name-section">
                <div className="section-kicker section-kicker--light">
                    <span className="section-number">03</span>
                    <span>The story behind the name</span>
                </div>
                <div className="name-layout">
                    <h2>A name, a palette,<br />a <em>journey.</em></h2>
                    <div className="name-parts">
                        <div>
                            <span className="name-part-label">AK</span>
                            <p>Is me — Aloknanda Kundu. Every piece carries a little of who I am and where I come from.</p>
                        </div>
                        <div>
                            <span className="name-part-label">PALETTES</span>
                            <p>Is every possibility waiting to happen — the colours, the experiments and the happy accidents that become something personal.</p>
                        </div>
                        <div>
                            <span className="name-part-label">Together</span>
                            <p>AK PALETTES is where my ideas and influences meet: Indian traditions, African cultures, portraits, nature and the beautiful in-between.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section className="process-section">
                <div className="section-kicker">
                    <span className="section-number">04</span>
                    <span>How a painting happens</span>
                </div>
                <ol className="process-list">
                    {process.map((step, index) => (
                        <li key={step.title}>
                            <span className="process-number">0{index + 1}</span>
                            <h3>{step.title}</h3>
                            <p>{step.text}</p>
                        </li>
                    ))}
                </ol>
                <Link className="text-link" href="/gallery">
                    See where it leads <ArrowIcon />
                </Link>
            </section>

            <ContactBand />
        </SiteLayout>
    );
}
