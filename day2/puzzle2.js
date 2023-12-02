const fs = require('node:fs');

try {
    const data = fs.readFileSync('./input.txt', 'utf8');

    // Parse games into a representation we want to work with
    const parsed = data.split("\n").map(line => {
        const [game, cubes] = line.split(':')

        const revelations = cubes.split(';')
            .map(
                line =>
                    line.split(',')
                        .map(
                            cube => {
                                const [num, color] = cube.trim().split(' ')

                                return {[color]: parseInt(num, 10)};
                            }
                        )
            );

        const id = game.split(' ').pop();

        return [id, revelations];
    });

    // Map each game into an object containing the min. amount of required colors
    const games = parsed.map(game => {
        const [id, revelations] = game;

        // Reduce into an object containing the min required colors of all revelations
        return revelations.reduce((prev, revelation) => {
            const minRequiredColors = revelation.reduce((prev, cur) => {
                const [color, num] = Object.entries(cur)[0];

                if (num > prev[color]) {
                    prev[color] = num;
                }

                return prev;
            }, { red: 0, green: 0, blue: 0});

            Object.entries(minRequiredColors).forEach(val => {
                const [color, num] = val;

                if (num > prev[color]) {
                    prev[color] = num;
                }
            })

            return prev;

        }, {red: 0, green: 0, blue: 0});
    });

    // Map reduce into sum of products
    const out = games.reduce((prev, cur) => {
        return prev + Object.entries(cur).map(revelation => Object.entries(revelation)[1][1]).reduce((prev, cur) => {
            return prev * cur;
        }, 1)
    }, 0);

    console.log(out);
} catch (err) {
    console.error(err);
}