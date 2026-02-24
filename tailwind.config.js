module.exports = {
  content: [
    "./application/**/*.php",
    "./application/**/*.html",
    "./index.php",
    "./_index.html",
    "./accept_index.html"
  ],
  theme: {
    extend: {
      colors: {
        primary: "#0066FF",
        secondary: "#020817",
        accent: "#F8FAFC"
      },
      fontFamily: {
        sans: ["Inter", "sans-serif"],
        heading: ["Montserrat", "sans-serif"]
      }
    }
  }
}