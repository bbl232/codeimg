$.post('/api/tags',{limit:8}).success(function(data){
  var tags = $.parseJSON(data);
  tags = tags["tags"];
  $.each(tags,function(k,v){
    var id = v.slice(1).replace(" ","_");
    $('#tags-div').append($("<button class='tag-toggle tag-btn btn btn-default' id='tag-"+id+"'>"+v+"</button>")        .click(function(){
          $(this).toggleClass('active');
          $(this).blur();
          update_results();
        })
    );
  });
});

function update_results(){
  $('#results-div').html("");
  $('#message').html("");
  tags=[];
  $('.active').each(function(k,v){
    tags.push(v.innerHTML);
  });
  var typed = $('#tags').val().split(",");
  $.each(typed,function(k,v){
    if(v != ""){
      tags.push(v);
    }
  });
  if(tags.length > 0){
    $.post('/api/snippet/from-tags',"tags="+tags.toString(),function(data){
      var result = $.parseJSON(data);
      if(result['status'] == "error"){
        $('#message').html("<br><div class='alert alert-danger'>"+result['message']+"</div>");;
      }
      else{
        $.each(result['snippets'],function(k,v){
          $('#results-div').append($("<div class='snippet-container'></div>")
            .html("<div class='code-panel panel panel-default'><div class='panel-heading'>"+v['name']+"</div><div class='panel-body'><div class='row'><div class='col-xs-6'><a href='show-snippet.php?id="+v['snippet']+"'><img class='code-image img-thumbnail' src='"+v['image_data']+"'></a></div><div class='col-xs-6'><p>Owner:"+v['owner']+"</p><div id='"+v['snippet']+"-tags'></div><div class='viewdiv'><a class='btn btn-primary' href='show-snippet.php?id="+v['snippet']+"'>View</a></div></div></div></div></div>"));
          $.each(v['tags'],function(tk,tv){
            if($.inArray(tv[0],tags) == -1){
              $('#'+v['snippet']+'-tags').append($("<span class='tag'></span>")
                .html(tv+"<br>"));
            }
            else{
              $('#'+v['snippet']+'-tags').append($("<span class='active-tag'></span>")
                .html(tv+"<br>"));
            }
          });
        });
      }
    });
  }
}

var myInput = document.getElementById("tags");
function keyHandler(e) {
    var RETURNKEY = 13;
    if(e.keyCode == RETURNKEY) {
        update_results();
        if(e.preventDefault) {
            e.preventDefault();
        }
        return false;
    }
}
myInput.addEventListener('keydown',this.keyHandler,false);
