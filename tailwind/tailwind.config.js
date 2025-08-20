module.exports = {
  content: [
    "./app/views/**/*.php",
    "./public/**/*.{html,js,php}",
    "./public/assets/js/**/*.js",
  ],
  theme: {
    extend: {
      fontFamily: {
        inter: ['Inter', 'sans-serif'],
      },
      fontSize: {
        '2xs': '0.625rem', // 10px
      },
      colors: {
        primary: '#092C4C',
        secondary: '#F3AF0E',
        info: '#2F80ED',
        success: '#27AE60',
        warning: '#E2B93B',
        error: '#EB5757',
        black1: '#000000',
        black2: '#1D1D1D',
        black3: '#282828',
        gray1: '#333333',
        gray2: '#4F4F4F',
        gray3: '#828282',
        gray4: '#BDBDBD',
        gray5: '#E0E0E0',
        gray6: '#5E6670',
        lightBlue: '#EFF7FD',
        grayMain: '#303030',
      },
      borderRadius: {
        md: '0.5rem',
      },
    },
  },
  plugins: [],
};