module.exports = {
  content: [
    "./app/views/**/*.php",
    "./public/**/*.{html,js,php}",
    "./public/assets/js/**/*.js",
    "./**/*.php"
  ],
  theme: {
    extend: {
      fontFamily: {
        inter: ['Inter', 'sans-serif'],
      },
      fontSize: {
        '2xs': '0.625rem', // 10px
        '3xs': '0.5625rem', // 9px - Added for notification badges with 99+ items
      },
      spacing: {
        '0.5': '0.125rem', // 2px
        '1.5': '0.375rem', // 6px
        '2.5': '0.625rem', // 10px
        '3.5': '0.875rem', // 14px
        '14': '3.5rem', // 56px
        '18': '4.5rem', // 72px
      },
      minWidth: {
        '3': '0.75rem', // 12px
        '3.5': '0.875rem', // 14px
        '4': '1rem', // 16px
      },
      width: {
        '2.5': '0.625rem', // 10px
        '3.5': '0.875rem', // 14px
      },
      height: {
        '2.5': '0.625rem', // 10px
        '3.5': '0.875rem', // 14px
      },
      inset: {
        '0.5': '0.125rem', // 2px
        '1.5': '0.375rem', // 6px
        '-0.5': '-0.125rem', // -2px
        '-1': '-0.25rem', // -4px
        '-1.5': '-0.375rem', // -6px
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
        tagsBg: '#EDEEF1'
      },
      borderRadius: {
        md: '0.3rem', // Change this value
      },
    },
  },
  plugins: [],
};