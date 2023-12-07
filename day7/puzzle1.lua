local reader = require('src/reader')
local hand = require('src/hand')
local sort = require('src/mergesort')

local Program = {}


function Program.run(file)
    local lines = reader.readFile(file)

    local hands = {}

    for _, line in pairs(lines) do
        table.insert(hands, hand.new(line))
    end

    local sorted = sort.sort(hands)

    local totalWinnings = 0

    for k, v in ipairs(sorted) do
        --print(string.format('%d: %s - Bid: %d', k, v:__tostring(), v.bid))
        totalWinnings = totalWinnings + (k * v.bid)
    end

    print(string.format('Total Winnings: %d', totalWinnings))
end


Program.run('input.txt')