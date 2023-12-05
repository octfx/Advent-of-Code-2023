export interface Range {
    source: number;
    destination: number;
    len: number;
}

export class AlmanacMap {
    public readonly source: string;
    public readonly destination: string;

    private readonly ranges: Array<Range>;

    public constructor(identifier: string) {
        if (!identifier.includes('-to-')) {
            throw {message: 'Wrong identifier format. Expected <source>-to-<destination>'};
        }

        const [source, destination] = identifier.split('-to-');
        this.source = source;
        this.destination = destination;
        this.ranges = [];
    }

    public addRange(range: string): void {
        const parts = range.split(' ').map(range => parseInt(range.trim()));

        if (parts.length !== 3) {
            console.error(`Passed range "${range}" is not valid.`);
            return;
        }

        const [destination, source, len] = parts;

        this.ranges.push({
            source,
            destination,
            len,
        })
    }

    public getMappedValue(input: number): number {
        const possible = this.ranges.find(range => {
            return input >= range.source && input <= (range.source + range.len);
        });

        if (typeof possible === 'undefined') {
            return input;
        }

        return input + (possible.destination - possible.source);
    }

    public getRanges(): Array<Range> {
        return this.ranges;
    }

    public toString() {
        return `${this.source} -> ${this.destination}:` + this.ranges.reduce((carry, range) => `${carry}\n${range.destination} ${range.source} ${range.len}`, '') + "\n";
    }
}