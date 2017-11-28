function productOf3Nums(arr) {
    let a = Number(arr[0]);
    let b = Number(arr[1]);
    let c = Number(arr[2]);
    if ((a >= 0 && b >= 0 && c < 0) || (a >= 0 && c >= 0 && b < 0) || (b >= 0 && c >= 0 && a < 0)) {
        console.log("Negative");
    }
    else {
        console.log("Positive");
    }
}

productOf3Nums([2, 3, -1]);
productOf3Nums([5, 4, 3]);
productOf3Nums([-3, -4, 5]);