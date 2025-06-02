import { Config } from "tailwindcss";
import { mtConfig } from "@material-tailwind/react";

const config: Config = {
  content: [
    ...
    "./node_modules/@material-tailwind/react/**/*.{js,ts,jsx,tsx}"
  ],
  plugins: [mtConfig],

  plugins: [
  flowbite(),
  // or:
  'flowbite-react',
]
};

export default config;