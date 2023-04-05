
const simpleGit = require('simple-git');
const git = simpleGit();

async function commitChanges() {
    try {
        // Stage changes
        await git.add('./*');
        console.log('Changes staged');

        // Commit with a custom message and date
        const customDate = "Tue Apr 5 12:00 2023 +0200"; // Change this to your desired date
        await git.commit('Automated commit by simple-git', {
            '--date': customDate
        });
        console.log('Commit successful');

        // Push changes (uncomment the line below to enable pushing)
        // await git.push('origin', 'your-branch-name');
        // console.log('Changes pushed to the repository');

    } catch (err) {
        console.error('Failed to commit changes:', err);
    }
}

// Run the commit function
commitChanges();
