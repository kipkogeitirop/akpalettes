import { Link, usePage } from '@inertiajs/react';
import { useState } from 'react';
import ArrowIcon from './ArrowIcon';
import useContact from './useContact';
import WhatsAppIcon from './WhatsAppIcon';

const navigation = [
    { label: 'Gallery', href: '/gallery' },
    { label: 'The artist', href: '/about' },
];

function Wordmark({ footer = false }) {
    return (
        <Link className={footer ? 'wordmark wordmark--footer' : 'wordmark'} href="/" aria-label="AK Palettes home">
            <span className="wordmark-mark">AK</span>
            <span className="wordmark-name">PALETTES</span>
        </Link>
    );
}

export default function SiteLayout({ children }) {
    const [menuOpen, setMenuOpen] = useState(false);
    const { url } = usePage();
    const { email, hasWhatsApp, whatsappUrl } = useContact();
    const isActive = (href) => url === href || url.startsWith(`${href}/`) || url.startsWith(`${href}?`);

    return (
        <>
            <header className="site-header">
                <Wordmark />

                <button
                    className="menu-toggle"
                    type="button"
                    aria-label={menuOpen ? 'Close navigation' : 'Open navigation'}
                    aria-expanded={menuOpen}
                    onClick={() => setMenuOpen(!menuOpen)}
                >
                    <span />
                    <span />
                </button>

                <nav className={`main-nav${menuOpen ? ' main-nav--open' : ''}`} aria-label="Main navigation">
                    {navigation.map((item) => (
                        <Link
                            className={isActive(item.href) ? 'is-active' : undefined}
                            href={item.href}
                            key={item.href}
                            aria-current={isActive(item.href) ? 'page' : undefined}
                        >
                            {item.label}
                        </Link>
                    ))}
                    <Link
                        className={isActive('/contact') ? 'nav-contact is-active' : 'nav-contact'}
                        href="/contact"
                        aria-current={isActive('/contact') ? 'page' : undefined}
                    >
                        Get in touch <ArrowIcon diagonal />
                    </Link>
                </nav>
            </header>

            <main>{children}</main>

            <footer className="site-footer">
                <Wordmark footer />
                <p>Where colours become stories.</p>
                <div className="footer-links">
                    <Link href="/gallery">Gallery</Link>
                    <Link href="/about">The artist</Link>
                    <Link href="/contact">Contact</Link>
                </div>
                <div className="footer-contact">
                    {hasWhatsApp && (
                        <a className="footer-email" href={whatsappUrl()} target="_blank" rel="noopener noreferrer">
                            WhatsApp <ArrowIcon diagonal />
                        </a>
                    )}
                    <a className="footer-email" href={`mailto:${email}`}>
                        Say hello <ArrowIcon diagonal />
                    </a>
                </div>
                <span className="footer-credit">© {new Date().getFullYear()} AK PALETTES</span>
            </footer>

            {hasWhatsApp && (
                <a
                    className="whatsapp-float"
                    href={whatsappUrl()}
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label="Chat with Aloknanda on WhatsApp"
                >
                    <WhatsAppIcon />
                    <span>Chat on WhatsApp</span>
                </a>
            )}
        </>
    );
}
