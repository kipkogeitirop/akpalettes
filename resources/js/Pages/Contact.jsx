import { Head } from '@inertiajs/react';
import ArrowIcon from '../Components/ArrowIcon';
import SiteLayout from '../Components/SiteLayout';
import useContact from '../Components/useContact';
import WhatsAppIcon from '../Components/WhatsAppIcon';

const topics = [
    {
        title: 'Buying an original',
        text: 'Fallen for a piece in the gallery? Ask me about it.',
        message: 'Hi Aloknanda, I’d love to ask about buying one of your original paintings.',
    },
    {
        title: 'Commissioning a painting',
        text: 'A story, a person, a place — tell me what you have in mind.',
        message: 'Hi Aloknanda, I’d like to talk about commissioning a painting.',
    },
    {
        title: 'Collaborations',
        text: 'Exhibitions, projects and creative partnerships.',
        message: 'Hi Aloknanda, I’d like to talk about a collaboration.',
    },
    {
        title: 'Just saying hello',
        text: 'Kind words and conversations about colour are always welcome.',
        message: 'Hi Aloknanda, I just wanted to say hello and that I love your work!',
    },
];

export default function Contact() {
    const { email, hasWhatsApp, whatsappNumber, whatsappUrl } = useContact();

    return (
        <SiteLayout>
            <Head title="Get in touch — AK PALETTES">
                <meta
                    name="description"
                    content="Get in touch with Aloknanda Kundu on WhatsApp or by email about original paintings, commissions and collaborations."
                />
            </Head>

            <section className="page-hero">
                <p className="eyebrow"><span /> Get in touch</p>
                <h1>Let’s talk <em>colour.</em></h1>
                <p className="page-hero-intro">
                    Whether it’s a question about a piece, an idea for a commission or simply a hello — I’d love to hear from you.
                </p>
            </section>

            <section className="contact-section">
                <div className="contact-channels">
                    {hasWhatsApp && (
                        <a className="contact-channel contact-channel--whatsapp" href={whatsappUrl()} target="_blank" rel="noopener noreferrer">
                            <span className="contact-channel-icon"><WhatsAppIcon /></span>
                            <span className="contact-channel-label">The quickest way</span>
                            <strong>Chat on WhatsApp</strong>
                            <span className="contact-channel-detail">+{whatsappNumber}</span>
                            <span className="contact-channel-arrow"><ArrowIcon diagonal /></span>
                        </a>
                    )}
                    <a className="contact-channel" href={`mailto:${email}`}>
                        <span className="contact-channel-icon">@</span>
                        <span className="contact-channel-label">{hasWhatsApp ? 'Prefer email?' : 'Write to me'}</span>
                        <strong>Send an email</strong>
                        <span className="contact-channel-detail">{email}</span>
                        <span className="contact-channel-arrow"><ArrowIcon diagonal /></span>
                    </a>
                </div>

                <div className="contact-topics">
                    <div className="section-kicker">
                        <span className="section-number">✳</span>
                        <span>What can I help with?</span>
                    </div>
                    <ul>
                        {topics.map((topic) => (
                            <li key={topic.title}>
                                <a
                                    href={hasWhatsApp
                                        ? whatsappUrl(topic.message)
                                        : `mailto:${email}?subject=${encodeURIComponent(topic.title)}&body=${encodeURIComponent(topic.message)}`}
                                    target={hasWhatsApp ? '_blank' : undefined}
                                    rel={hasWhatsApp ? 'noopener noreferrer' : undefined}
                                >
                                    <span>
                                        <h3>{topic.title}</h3>
                                        <p>{topic.text}</p>
                                    </span>
                                    <ArrowIcon />
                                </a>
                            </li>
                        ))}
                    </ul>
                </div>
            </section>

            <section className="closing-section">
                <span className="closing-star">✳</span>
                <p>For the love of colour,<br />and all the stories it can tell.</p>
                <span className="closing-signature">Aloknanda</span>
            </section>
        </SiteLayout>
    );
}
