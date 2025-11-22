# Portfolio React

Portfolio website converted from Next.js to standard React using Vite.

## Tech Stack

- React 18
- TypeScript
- Vite
- Tailwind CSS
- Framer Motion
- Lucide React Icons

## Getting Started

### Install Dependencies

```bash
npm install
```

### Development

```bash
npm run dev
```

The app will be available at `http://localhost:5173`

### Build

```bash
npm run build
```

The production build will be in the `dist` folder.

### Preview Production Build

```bash
npm run preview
```

## Project Structure

```
portfolio-react/
├── public/
│   └── images/        # Static images
├── src/
│   ├── components/    # React components
│   │   ├── sections/  # Page sections
│   │   ├── Navigation.tsx
│   │   ├── Footer.tsx
│   │   └── AnimatedBackground.tsx
│   ├── App.tsx        # Main app component
│   ├── main.tsx       # Entry point
│   └── index.css      # Global styles
├── index.html
├── package.json
├── vite.config.ts
└── tailwind.config.ts
```

## Notes

- Contact form API endpoint needs to be configured (currently points to `/api/contact`)
- All images are stored in `public/images/`
- This is a single-page application with smooth scrolling navigation

