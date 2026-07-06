import { marked } from 'marked';
import DOMPurify from 'dompurify';

marked.setOptions({
    gfm: true,
    breaks: true,
});

export function useMarkdown() {
    function render(markdown) {
        if (!markdown) return '';
        const raw = marked.parse(markdown);
        return DOMPurify.sanitize(raw, {
            ADD_ATTR: ['target', 'rel'],
        });
    }

    function extractHeadings(markdown) {
        const headings = [];
        const lines = markdown?.split('\n') ?? [];

        for (const line of lines) {
            const match = line.match(/^(#{1,6})\s+(.+)$/);
            if (match) {
                const level = match[1].length;
                const text = match[2].trim();
                const id = text
                    .toLowerCase()
                    .normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '')
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/(^-|-$)/g, '');

                headings.push({ level, text, id });
            }
        }

        return headings;
    }

    return { render, extractHeadings };
}
