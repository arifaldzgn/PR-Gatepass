const fs = require('fs');
const puppeteer = require('puppeteer');

(async () => {
    const userDataDir = './temp/puppeteer_data';

    // Check if userDataDir exists, create it if not
    if (!fs.existsSync(userDataDir)) {
        fs.mkdirSync(userDataDir, { recursive: true });
    }

    // Launch Puppeteer with the specified userDataDir
    const browser = await puppeteer.launch({
        userDataDir: userDataDir
    });

    // Continue with the rest of your Puppeteer logic
    const page = await browser.newPage();
    await page.goto('https://www.google.com');
    await page.pdf({ path: 'google.pdf', format: 'A4' });

    await browser.close();
})();
