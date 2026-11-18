// Renders the favicons and app icons from artwork/signet.svg: node scripts/icons.mjs
//   public/favicon.svg             the signet itself, for modern browsers
//   public/favicon.ico             32 px, for everything that still asks for /favicon.ico
//   public/images/favicon-96x96.png
//   public/apple-touch-icon.png    180 px on white (iOS fills transparency with black)
//   public/images/icon-192.png, icon-512.png   for site.webmanifest
import { copyFile, readFile, writeFile } from 'node:fs/promises';
import { dirname, join } from 'node:path';
import { fileURLToPath } from 'node:url';
import sharp from 'sharp';

const root = join(dirname(fileURLToPath(import.meta.url)), '..');
const signet = await readFile(join(root, 'artwork/signet.svg'));

/** The signet centred on a square, filling `fill` of it. */
async function icon(size, { fill = 0.9, background = null } = {}) {
	const inner = Math.round(size * fill);
	const mark = await sharp(signet, { density: 600 })
		.resize(inner, inner, { fit: 'contain', background: { r: 0, g: 0, b: 0, alpha: 0 } })
		.png()
		.toBuffer();

	return sharp({
		create: {
			width: size,
			height: size,
			channels: 4,
			background: background ?? { r: 0, g: 0, b: 0, alpha: 0 },
		},
	})
		.composite([{ input: mark, gravity: 'center' }])
		.png()
		.toBuffer();
}

/** A one-image ICO file wrapping a PNG, which every browser since IE 11 reads. */
function ico(png, size) {
	const header = Buffer.alloc(22);
	header.writeUInt16LE(0, 0);
	header.writeUInt16LE(1, 2);
	header.writeUInt16LE(1, 4);
	header.writeUInt8(size, 6);
	header.writeUInt8(size, 7);
	header.writeUInt8(0, 8);
	header.writeUInt8(0, 9);
	header.writeUInt16LE(1, 10);
	header.writeUInt16LE(32, 12);
	header.writeUInt32LE(png.length, 14);
	header.writeUInt32LE(22, 18);

	return Buffer.concat([header, png]);
}

const white = { r: 255, g: 255, b: 255, alpha: 1 };

await copyFile(join(root, 'artwork/signet.svg'), join(root, 'public/favicon.svg'));
await writeFile(join(root, 'public/favicon.ico'), ico(await icon(32, { fill: 1 }), 32));
await writeFile(join(root, 'public/images/favicon-96x96.png'), await icon(96, { fill: 1 }));
await writeFile(join(root, 'public/apple-touch-icon.png'), await icon(180, { fill: 0.72, background: white }));
await writeFile(join(root, 'public/images/icon-192.png'), await icon(192, { fill: 0.72, background: white }));
await writeFile(join(root, 'public/images/icon-512.png'), await icon(512, { fill: 0.72, background: white }));

console.log('Wrote favicon.svg, favicon.ico, favicon-96x96.png, apple-touch-icon.png, icon-192.png and icon-512.png');
