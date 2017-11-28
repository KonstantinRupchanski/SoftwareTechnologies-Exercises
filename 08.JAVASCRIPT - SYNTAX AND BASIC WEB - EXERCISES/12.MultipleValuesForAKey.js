function multipleValuesForAKey(numbers){
    let input = [];
    let duplicateEntry = numbers[numbers.length-1];

    for(let i=0 ;i<numbers.length-1;i++){
        let keyValue = numbers[i].split(' ');
        let command = keyValue[0];
        input[command] = keyValue[1];
        if(duplicateEntry==command){
            console.log(input[command]);
        }
    }
    if(duplicateEntry in input){

    }
    else{
        console.log("None")
    }
}

multipleValuesForAKey(["key value", "key eulav", "test tset", "key"])