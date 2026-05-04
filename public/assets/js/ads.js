/**
 * Poudra-Pop Trash Popups Engine
 * Code and comments in English as requested.
 */
function spawnTrashPopup() {
    /**
     * Poudra-Pop Ultra-Chaos Template Pack (20 items)
     * Category breakdown: Medical, Financial, Paranormal, Relationship, Security.
     */
    const templates = [
        // --- CATEGORY: MEDICAL & BODY ---
        { 
            theme: 'medical', 
            title: '🦷 DENTAL EMERGENCY', 
            text: 'YOUR TEETH ARE DISSOLVING IN REAL TIME. CLICK TO APPLY CEMENT.', 
            img: 'https://blob.gifcities.org/gifcities/AMVN2XKNFE2JGKEIEKNZ7ADQLBYIPYOE.gif', 
            btn: 'FIX MY SMILE' 
        },
        { 
            theme: 'medical', 
            title: '🧪 TEST SUBJECT #402', 
            text: 'CONGRATULATIONS! YOU HAVE BEEN SELECTED FOR LIVE HUMAN TESTING.', 
            img: '', 
            btn: 'START INJECTION' 
        },
        { 
            theme: 'medical', 
            title: '📉 HEART RATE: 240 BPM', 
            text: 'YOUR HEART IS BEATING TOO FAST. BUY THE "CHILL-OUT" SACHET NOW.', 
            img: 'https://blob.gifcities.org/gifcities/LHPDUXCVOES43OJBZV7NQPKKKL6YAUJW.gif', 
            btn: 'STABILIZE ME' 
        },

        // --- CATEGORY: SCAMS & MONEY ---
        { 
            theme: 'scam', 
            title: '💵 COLOMBIAN INHERITANCE', 
            text: 'A DISTANT BEAR UNCLE LEFT YOU 500KG OF RAW SUGAR. PAY SHIPPING.', 
            img: 'https://blob.gifcities.org/gifcities/CELW42QUOOSKNEYGCF2YIY7GYXDHWPYH.gif', 
            btn: 'COLLECT LEGACY' 
        },
        { 
            theme: 'scam', 
            title: '₿ POUDRA-COIN EXPLOSION', 
            text: 'POUDRA-COIN IS UP 5000%. INVEST YOUR LIFE SAVINGS TO WIN BIG.', 
            img: 'https://blob.gifcities.org/gifcities/5IYER54L6Z4LAR7GR5GXUV3D6ZOHFFNJ.gif', 
            btn: 'TO THE MOON' 
        },
        { 
            theme: 'tax', 
            title: '🚔 CUSTOMS INTERCEPTION', 
            text: 'YOUR LAST "CANDY" SHIPMENT WAS SEIZED. PAY THE BRIBE TO RELEASE.', 
            img: 'https://blob.gifcities.org/gifcities/LJR6HYINCIKPKZBVS4KHLI2HGRYXORYB.gif', 
            btn: 'PAY THE AGENT' 
        },
        { 
            theme: 'scam', 
            title: '📦 WINNER! WINNER!', 
            text: 'YOU WON A YEAR OF FREE POUDRA-POP. WE JUST NEED YOUR MOTHER\'S MAIDEN NAME.', 
            img: 'https://blob.gifcities.org/gifcities/F2SISCBRZ3MF4D57P5O4LE3MTXTQINCR.gif', 
            btn: 'CLAIM PRIZE' 
        },

        // --- CATEGORY: RELATIONSHIPS ---
        { 
            theme: 'love', 
            title: '🧸 LONELY URSIDS NEAR YOU', 
            text: 'URSULA IS 0.5KM AWAY AND SHE HAS THE MUNCHIES. DON\'T WAIT.', 
            img: 'https://blob.gifcities.org/gifcities/SH4AZL6MZHJYGHP2X3L2KENONYLMAROG.gif', 
            btn: 'SEND A MESSAGE' 
        },
        { 
            theme: 'love', 
            title: '💍 MAIL-ORDER GRIZZLY', 
            text: 'TIRED OF EATING CRYSTALS ALONE? ORDER A COMPANION FROM BOGOTA.', 
            img: 'https://blob.gifcities.org/gifcities/AAKRYEPXVJ5UL2XQW7MQHJCI23AHSWMY.gif', 
            btn: 'BROWSE CATALOG' 
        },

        // --- CATEGORY: PARANORMAL & WEIRD ---
        { 
            theme: 'ufo', 
            title: '🛸 ABDUCTION SCHEDULED', 
            text: 'THE BEAM IS READY. PLEASE STAND OUTSIDE WITH YOUR CRYSTALS.', 
            img: 'https://blob.gifcities.org/gifcities/JJCK75V5W4FGI7T6FA7ORNRMWI46V26R.gif', 
            btn: 'BEAM ME UP' 
        },
        { 
            theme: 'glitch', 
            title: '👁️ THE EYE IS WATCHING', 
            text: 'WE KNOW WHAT YOU BOUGHT. WE KNOW WHAT YOU SNIFFED. STOP NOW.', 
            img: 'https://blob.gifcities.org/gifcities/RPW7CSVXMJIICTGCW4JEE3UWOZDVWLNQ.gif', 
            btn: 'I AM SORRY' 
        },
        { 
            theme: 'death', 
            title: '⌛ 00:05 MINUTES LEFT', 
            text: 'YOUR FREE TRIAL OF LIFE IS EXPIRING. RENEW SUBSCRIPTION?', 
            img: 'https://blob.gifcities.org/gifcities/AIS6PIGSFRDVH46H6VKMT3CWGB465UZ2.gif', 
            btn: 'RENEW (100€)' 
        },

        // --- CATEGORY: SECURITY & TECH ---
        { 
            theme: 'virus', 
            title: '🔥 OVERHEATING DETECTED', 
            text: 'YOUR BROWSER IS ON FIRE. CLICK TO DOWNLOAD AN ICE CUBE.', 
            img: 'https://blob.gifcities.org/gifcities/SZYTEM4ANTI2PVXFIXAU3LLCUBGBNMXJ.gif', 
            btn: 'COOL DOWN' 
        },
        { 
            theme: 'virus', 
            title: '📂 DELETING SYSTEM32', 
            text: 'UNAUTHORIZED CANDY ACCESS DETECTED. WIPING YOUR HARD DRIVE...', 
            img: 'https://blob.gifcities.org/gifcities/63MO6AIUZRE4BINCAD2D454ZF2MZMQN5.gif', 
            btn: 'ABORT ABORT!' 
        },
        { 
            theme: 'glitch', 
            title: '⚠️ DATA CORRUPTION', 
            text: 'f87sh 9sh2 jsh29... THE FACTORY IS LEAKING INTO YOUR RAM.', 
            img: 'https://blob.gifcities.org/gifcities/4JRI7PPJ7HPEPCCJLJM52YWO7XN32FTF.gif', 
            btn: 'r3b00t' 
        },
    ];

    const data = templates[Math.floor(Math.random() * templates.length)];
    
    // Position and messiness
    const posX = Math.random() * (window.innerWidth - 300);
    const posY = Math.random() * (window.innerHeight - 350);
    const rotation = (Math.random() * 14) - 7; // Random tilt between -7 and 7 deg

    const html = `
        <div class="shitty-ad ad-${data.theme}" 
             style="top:${posY}px; left:${posX}px; transform: rotate(${rotation}deg); visibility: hidden;">
            <div class="ad-header">
                <span>${data.title}</span>
                <button onclick="this.parentElement.parentElement.remove()">[X]</button>
            </div>
            <div class="ad-body">
                <p class="ad-text">${data.text}</p>
                <div class="ad-image-container">
                    <img src="${data.img}" alt="trash visual" class="ad-gif" onload="this.parentElement.parentElement.parentElement.style.visibility='visible'">
                </div>
                <button class="ad-cta">${data.btn}</button>
            </div>
        </div>
    `;

    $('body').append(html);
}

$(document).ready(function() {
    setTimeout(spawnTrashPopup, 1 * 200);

    // Aggressive spawning every 10 seconds
    setInterval(spawnTrashPopup, 10000);
});