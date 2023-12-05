import * as fs from 'fs';
import {AlmanacMap} from "./AlmanacMap";

export class Almanac {
    private seeds: Array<number>;

    private maps: Map<string, AlmanacMap>;
    private reverseMap: Map<string, string>;

    private constructor() {
        this.seeds = [];
        this.maps = new Map<string, AlmanacMap>();
        this.reverseMap = new Map<string, string>();
    }

    public static read(filePath: string): Almanac|null {
        let data: string;
        try {
            data = fs.readFileSync(filePath, 'utf8');
        } catch (e) {
            return null;
        }

        const almanac = new Almanac();

        const lines = data.trim().split("\n");

        almanac.addSeeds(lines[0]);

        let currentMap: string|null = null;

        for (const line of lines) {
            if (line.trim().length === 0) {
                continue;
            }

            if (line.includes('map:')) {
                currentMap = line.replace('map:', '').trim();
                const map = almanac.addMap(currentMap);
                currentMap = map.source;
            } else if (currentMap !== null) {
                almanac.maps.get(currentMap)?.addRange(line);
            }
        }

        return almanac;
    }

    public getSeeds(): Array<number> {
        return this.seeds;
    }

    public getMap(source: string, reverse: boolean = false): AlmanacMap|undefined {
        if (reverse) {
            let mappedSource = this.reverseMap.get(source) ?? '';
            if (typeof mappedSource === 'undefined') {
                throw {message: `Could not find map with destination "${source}".`};
            }

            source = mappedSource;
        }

        return this.maps.get(source);
    }

    public getSeedLocation(seed: number): number {
        let next = 'seed';

        do {
            let map = this.getMap(next);

            if (typeof map === 'undefined') {
                throw {message: `Could not find map with source "${next}".`}
            }

            seed = map.getMappedValue(seed);

            next = map.destination;
        } while (next !== 'location');

        return seed;
    }

    /**
     * This is the worst implementation as it is just brute force
     */
    public getLowestLocationForSeedRange() {
        const tuples = [];

        for (let i = 0; i < this.seeds.length; i += 2) {
            tuples.push({
                start: this.seeds[i],
                len: this.seeds[i+1],
            })
        }

        let min = Number.MAX_VALUE;

         tuples.forEach(tuple => {

            for (let i = tuple.start; i < tuple.start + tuple.len; i++) {
                const loc = this.getSeedLocation(i);
                if (loc < min) {
                    min = loc;
                    console.log(min);
                }
            }
        });

        return min;
    }

    private addSeeds(seeds: string): void {
        if (!seeds.startsWith('seeds:')) {
            throw {message: 'Passed data is not a valid seeds string.'};
        }

        this.seeds = seeds.split(':')
            .pop()
            ?.split(' ')
            .filter(seed => seed.trim().length > 0)
            .map(seed => parseInt(seed.trim(), 10)) ?? [];
    }

    private addMap(identifier: string): AlmanacMap {
        const map = new AlmanacMap(identifier);

        this.maps.set(map.source, map);
        this.reverseMap.set(map.destination, map.source);

        return map;
    }

    public toString() {
        this.maps.forEach(map => console.log(map.toString()));
    }
}