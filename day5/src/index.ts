import {Almanac} from "./Almanac";


class Program {

    public run(): void {
        const args = process.argv.slice(2);

        if (args.length !== 1) {
            console.error('Run program as day5.js input.txt');
            return;
        }

        const almanac = Almanac.read(args[0]);

        if (almanac === null) {
            console.error('Almanac could not read input file.');
            return;
        }

        const answer = almanac.getSeeds().map(seed => almanac.getSeedLocation(seed))
            .reduce((previousValue, currentValue) => {
                if (currentValue < previousValue) {
                    return currentValue;
                }

                return previousValue;
            }, Number.MAX_VALUE);

        console.log(`Puzzle 1: ${answer}`);

        const min = almanac.getLowestLocationForSeedRange();
        console.log(`Puzzle 2: ${min}`);
    }
}

const program = new Program();
program.run();
