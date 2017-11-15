function multiplyOrDivideANumber(arr) {
    let n = Number(arr[0]);
    let x = Number(arr[1]);
    if (x>=n){
        console.log(n*x);
    }
    else{
        console.log(n/x);
    }
}

multiplyOrDivideANumber([2,3]);
multiplyOrDivideANumber([13,13]);
multiplyOrDivideANumber([144,12]);