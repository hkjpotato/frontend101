var arr = [4, 8, 7, 1, 7, 9];
var arr = [1, 2, 7, 100, 200];


var quickSort = function(arr) {
	// quickSortHelper(arr, start, end);
}

var quickSortHelper = function(arr, left, right) {
	var i = left, j = right;


	var index = Math.floor((left + right) / 2);

	var pivot = arr[index];

	console.log(pivot);

	while (i <= j) {
		while (arr[i] < pivot) {
			//this step no longer ensure that arr[i] < pivot
			//but arr[0 ~ i - 1] < pivot for sure
			i++;
		}


		while (arr[j] > pivot) {
			//this step no longer ensure that arr[j] > pivot
			//but arr[j + 1 ~ end] > pivot for sure
			j--;
		}

		if (i <= j) {
			// not finish, not meeting

			//can arr[j] now > pivot? no! if so, j will still be minus 1
			//it will only stop when I got a j that arr[j] <= pivot

			//same to i, it will stop when I got a i that arr[i] >= pivot

			//that is why we use < || > for the while loop since we must ensure they will stop (e.g pivot itself will definitely stop)
			
			//at this moment we can ensure that we can have arr[i] >= pivot and arr[j] <= pivot
			//exchange them so that
			//arr[i] <= pivot && arr[j]>=pivot

			//once we have i++ j--
			//we cannot ensure that 0 to i - 1 is all < pivot, only we can ensure that 0 to i - 1 is <= pivot
			//we can also ensure that j + 1 to end is >= pivot
			temp = arr[i];
			arr[i] = arr[j];
			arr[j] = temp;
			console.log(arr);

			//this step no longer ensure that arr[j] > pivot
			i++;
			j--;
		}
	}

	//finally i will become i = j + 1
	console.log(i, j);
	return i;
	//move pivot to the 
}
var result = quickSortHelper(arr, 0, arr.length - 1)

console.log(result);

console.log(arr);