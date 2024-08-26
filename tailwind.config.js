/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*/.{html,js}"],
  theme: {
    extend: {
      boxShadow: {
        'text-shadow': '0 4px 6px rgba(0, 0, 0, 0.5)', // Custom shadow for text
      }
    },
  },
  plugins: [require('@tailwindcss/typography'),],
}
