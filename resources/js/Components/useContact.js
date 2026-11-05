import { usePage } from '@inertiajs/react';

export default function useContact() {
    const { contact } = usePage().props;

    return {
        email: contact.email,
        whatsappNumber: contact.whatsapp,
        hasWhatsApp: Boolean(contact.whatsapp),
        whatsappUrl: (message = 'Hi Aloknanda, I came across AK PALETTES and would love to chat.') => (
            contact.whatsapp ? `https://wa.me/${contact.whatsapp}?text=${encodeURIComponent(message)}` : null
        ),
    };
}
