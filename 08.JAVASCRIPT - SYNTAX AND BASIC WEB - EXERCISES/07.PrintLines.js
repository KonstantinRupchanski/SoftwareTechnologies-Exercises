function printLines(input) {
    for (i = 0; i < input.length; i++) {
        if (input[i] == "Stop") {
            break;
        }
        console.log(input[i]);
    }
}

// printLines(["Line 1", "Line 2", "Line 3", "Stop"]);
printLines([`3`, `6`, `5`, `4`, `Stop`, `10`, `12`]);