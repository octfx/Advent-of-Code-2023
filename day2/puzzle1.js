const fs = require('node:fs');

const puzzleTest = {
    red: 12,
    green: 13,
    blue: 14
}

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

    // Filter out all games which contain cubes that are greater than out test numbers
    const validGames = parsed.filter(game => {
        const [id, revelations] = game;

        // The game was valid if no subsets were removed
        return revelations.filter(revelation => {
            // These are the actual cube revelations, the number must be lower than our tests
            return revelation.reduce((prev, cur) => {
                const [color, num] = Object.entries(cur)[0];
                return prev && num <= puzzleTest[color];
            }, true)
        }).length === revelations.length;
    });

    // Sum up the ids
    const out = validGames.reduce((prev, cur) => {
        return prev + parseInt(cur[0]);
    }, 0);

    console.log(out);
} catch (err) {
    console.error(err);
}