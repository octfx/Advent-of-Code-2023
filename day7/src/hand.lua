local Hand = {}

local metatable = {}
local methodtable = {}


local typeNames = {
    [7] = "Five of a kind",
    [6] = "Four of a kind",
    [5] = "Full house",
    [4] = "Three of a kind",
    [3] = "Two pair",
    [2] = "One pair",
    [1] = "High card",
}

metatable.__index = methodtable


--- Parse a hand string into numbers
---
--- @param hand string
--- @return table, table, number
local function handToNum(hand)
    local nums = {}
    local numsSet = {}

    local numJoker = 0

    for i = 1, #hand do
        local c = hand:sub(i,i)
        local num

        if c == 'A' then
            num = 14
        elseif c == 'K' then
            num = 13
        elseif c == 'Q' then
            num = 12
        elseif c == 'J' then
            num = 11
            numJoker = numJoker + 1
        elseif c == 'T' then
            num = 10
        else
            num = tonumber(c, 10)
        end

        table.insert(nums, num)
    end

    for _, v in pairs(nums) do
        if type(numsSet[v]) == 'number' then
            numsSet[v] = numsSet[v] + 1
        else
            numsSet[v] = 1
        end
    end

    return nums, numsSet, numJoker
end


function methodtable:__tostring()
    local max, distinct = self:getMaxDistinct()

    return string.format(
        "Hand: %s - Type: %s - Joker: %d - Max: %d - Distinct: %d",
        self.cards,
        typeNames[self:getType()],
        self.numJoker,
        max,
        distinct
    )
end


function methodtable.getMaxDistinct(self)
    local distinct = 0
    local maxCount = 0
    local maxCard

    for card, count in pairs(self.set) do
        if type(count) == 'number' then
            distinct = distinct + 1

            if count > maxCount then
                maxCount = count
                maxCard = card
            end
        end
    end

    self.maxCard = maxCard

    if self.puzzle2 and maxCard ~= 11 then
        if self.numJoker > 0 then
            distinct = distinct - 1
        end

        maxCount = math.min(5, maxCount + self.numJoker)
    end

    distinct = math.max(1, distinct)

    return maxCount, distinct
end

--- Compare a card to this card
---
--- -1 0 1
---
--- @param self table
--- @param hand table
--- @return number
function methodtable.compare(self, hand)
    local handType = hand:getType()
    local selfType = self:getType()

    -- Second order rule, check first highest card
    if handType == selfType then
        local cards1 = self.cardNums
        local cards2 = hand.cardNums

        for i = 1, #cards1 do
            local left = cards1[i]
            local right = cards2[i]

            --if self.puzzle2 and left == 11 and self.numJoker > 0 and self.maxCard ~= 11 then
            --    left = 1
            --end
            --
            --if self.puzzle2 and right == 11 and hand.numJoker > 0 and hand.maxCard ~= 11 then
            --    right = 1
            --end

            if left > right then
                return 1
            elseif left < right then
                return -1
            end
        end
    end

    return selfType - handType
end


---
--- 7 = Five of a Kind
--- 6 = Four
--- 5 = Full House
--- 4 = Three
--- 3 = Two Pair
--- 2 = One Pair
--- 1 = High Card
function methodtable.getType(self)
    local typeNum = 0

    local maxCount, distinct = self:getMaxDistinct()

    -- Five of a type
    if distinct == 1 and maxCount == 5 then
        typeNum = 7
    -- Four of a kind
    elseif distinct == 2 and maxCount == 4 then
        typeNum = 6
    -- Full House
    elseif distinct == 2 and maxCount == 3 then
        typeNum = 5
    -- Three of a kind
    elseif maxCount == 3 and distinct > 2 then
        typeNum = 4
    -- Two Pairs
    elseif distinct == 3 and maxCount == 2 then
        typeNum = 3
    -- One Pairs
    elseif distinct == 4 and maxCount == 2 then
        typeNum = 2
    else
        typeNum = 1
    end

    return typeNum
end

--- Instantiate a new hand
---
--- @param input string
function Hand.new(input, puzzle2)
    if puzzle2 then
        --input = convertHandToPuzzle2(input)
    end

    local parts = {}
    for str in input:gmatch('%S+') do
        table.insert(parts, str)
    end

    local cardNums, set, joker = handToNum(parts[1], puzzle2)

    local instance = {
        cards = parts[1],
        bid = tonumber(parts[2], 10),
        cardNums = cardNums,
        set = set,
        type = 0,
        numJoker = joker,
        puzzle2 = puzzle2
    }

    setmetatable( instance, metatable )

    return instance
end


return Hand