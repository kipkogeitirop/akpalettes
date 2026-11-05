import { Link } from '@inertiajs/react';
import ArrowIcon from './ArrowIcon';
import useContact from './useContact';
import WhatsAppIcon from './WhatsAppIcon';

export default function ContactBand({
    title = <>Have a story you’d like <em>painted?</em></>,
    text = 'Whether you’ve fallen for a piece in the gallery or have an idea for something new, I’d love to hear from you.',
    message,
}) {
    const { hasWhatsApp, whatsappUrl } = useContact();

    return (
        <section className="contact-band">
            <div>
                <span className="closing-star">✳</span>
                <h2>{title}</h2>
                <p>{text}</p>
            </div>
            <div className="contact-band-actions">
                {hasWhatsApp && (
                    <a className="button button--whatsapp" href={whatsappUrl(message)} target="_blank" rel="noopener noreferrer">
                        <WhatsAppIcon /> Message on WhatsApp
                    </a>
                )}
                <Link className="button button--outline" href="/contact">
                    Other ways to reach me <ArrowIcon />
                </Link>
            </div>
        </section>
    );
}
