# ea-vertical-progress
create a vertical progress bar on a div

# Install

``` bower install ea-vertical-progress```


##initialize 

``` progress = new EAProgressVertical( parent ,[ initialValue, type, time, milestoneArray])  ```

####parent : required
jQuery Object which will act as the outer container

####initialValue
```default : 0``` <br /> 
the initial value of the the progress object ```(0 - 100)```

####type
```default : 'fill'``` <br /> 
the type of progress can either be ```'fill'``` or ```'empty'```

####time
```default : 10000``` <br /> 
time in milliseconds taken for progress to reach from 0% to 100%

####milestoneArray
```default : [0, 100]``` <br /> 
Array of breakpoints <br /> 
additional functionality to provide breakpoints to the progress 
if it doesnt find 0 and 100 it adds them


##Start Animation
``` progress.startProgress() ``` <br /> 
start the progress according to the direction as provided in initialize

##Stop Progress
``` progress.stopProgress([milestone])  ``` <br /> 
Stop the progress 

####milestone 
```default : false ``` <br /> 
boolean  <br /> 
false - the current progress <br /> 
true - the milestone closest to the progress

##Set Progress
```progress.setProgress(value, [slow])``` <br /> 
sets the progress to the given value

####value (required)
integer (0 - 100)

####slow
```default : false``` <br /> 
Speed of animation ```true``` or ```false``` <br /> 
slow takes the progress speed






#Example

```
progress = new EAProgressVertical( $('.bottle'), 0, 'fill', 10000, [25,50,75] );
	
	$('.change-progress').on('mousedown', function(e){	
		progress.startProgress();
	});
	
	$('.change-progress').on('mouseup', function(e){
		pro = progress.stopProgress(true);
		progress.setProgress(pro);
	})
	```
