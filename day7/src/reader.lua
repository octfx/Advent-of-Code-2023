local Reader = {}

local metatable = {}
local methodtable = {}

metatable.__index = methodtable


--- Reads all lines of a file
---
--- @param file string
function Reader.readFile(file)
    local lines = {}

    for line in io.lines(file) do
        lines[#lines + 1] = line
    end

    return lines
end


return Reader