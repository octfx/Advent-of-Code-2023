local MergeSort = {}

function MergeSort.merge(left, right)
    local new = {}

    while (#left > 0 and #right > 0) do
        if left[1]:compare(right[1]) <= 0 then
            table.insert(new, table.remove(left, 1))
        else
            table.insert(new, table.remove(right, 1))
        end
    end

    while (#left > 0) do
        table.insert(new, table.remove(left, 1))
    end

    while (#right > 0) do
        table.insert(new, table.remove(right, 1))
    end

    return new
end


function MergeSort.sort(list)
    if #list <= 1 then
        return list
    end

    local half = #list / 2
    local left = {}
    local right = {}

    for k, v in pairs(list) do
        local into = left
        if k > half then

            into = right
        end

        table.insert(into, v)
    end

    left = MergeSort.sort(left)
    right = MergeSort.sort(right)

    return MergeSort.merge(left, right)
end

return MergeSort