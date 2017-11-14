$('#radioBtn a').on('click', function(){
    var sel = $(this).data('title');
    var tog = $(this).data('toggle');
    $('#'+tog).prop('value', sel);
    
    $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
    $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');
  
    var regex = new RegExp(sel, "i");
    var output = '<div class="row">';
      projects.forEach(function(val) {
        if ((val.tags.search(regex) != -1)) {
          const tags = val.tags.split(' ')
          const imageLink = val.hasOwnProperty("img") ? val.img : 'project.jpg'
          output += '<div class="well well-sm">';
          output += '<div class="row"><div class="col-sm-3">';
          output += '<img src="img/' + imageLink + '" class="img-responsive center-block">'
          output += '</div><div class="col-sm-9">';
          output += '<h4>' + val.title + '</h4>';
          output += '<p>' + val.description + '</p><p>';
          if (val.link) output += '<a href="' + val.link + '" target="_blank">Project Link</a>';
          if (val.github && val.link) output += ' | ';
          if (val.github) output += '<a href="' + val.github + '" target="_blank">Github</a>';
          output += '</p>'
          tags.forEach(function(tag) {
            output += '<div class="tag">' + tag + '</div>';
          });
          output += '</div></div></div>';
        }
      });
      output += '</div>';
      $('#results').html(output);
})
document.getElementById('start').click();
$('#total').text(projects.length);