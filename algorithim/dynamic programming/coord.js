var obj = {
    a: 1,
    b: 'c'
}

console.log(JSON.stringify(obj, replacer, 2));

function replacer(key, value) {
    console.log(key, value);
    if (typeof value === "string") {
        return "nihao";
    }
    return value;
}