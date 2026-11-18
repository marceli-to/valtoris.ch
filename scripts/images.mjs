// Renders the photos listed in resources/images/images.json to AVIF, WebP and JPEG in
// public/images, one file per width: node scripts/images.mjs
// Never enlarges: a width above the source's is skipped.
import { readFile, mkdir } from 'node:fs/promises';
import { dirname, join } from 'node:path';
import { fileURLToPath } from 'node:url';
import sharp from 'sharp';

const root = join(dirname(fileURLToPath(import.meta.url)), '..');
const sources = join(root, 'resources/images');
const output = join(root, 'public/images');

const formats = {
	avif: (image) => image.avif({ quality: 55, effort: 6 }),
	webp: (image) => image.webp({ quality: 76 }),
	jpg: (image) => image.jpeg({ quality: 80, mozjpeg: true }),
};

const images = JSON.parse(await readFile(join(sources, 'images.json'), 'utf8'));
await mkdir(output, { recursive: true });

for (const [name, image] of Object.entries(images)) {
	if (name.startsWith('_')) {
		continue;
	}

	for (const width of image.widths) {
		if (width > image.width) {
			console.warn(`skip ${name} at ${width}px: the source is only ${image.width}px wide`);
			continue;
		}

		for (const [extension, encode] of Object.entries(formats)) {
			const file = join(output, `${name}-${width}.${extension}`);
			const resized = sharp(join(sources, image.source)).rotate().resize({ width, withoutEnlargement: true });
			const { size } = await encode(resized).toFile(file);
			console.log(`${name}-${width}.${extension}`.padEnd(32), `${Math.round(size / 1024)} KB`);
		}
	}
}
