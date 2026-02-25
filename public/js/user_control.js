//Control Ajax
    var id_ = document.getElementById("id_get").value;
    var cd_ = document.getElementById("cd_get").value;
function isPhoneSize() {
  return window.innerWidth <= 1200;
}document.getElementById('view_profile').addEventListener('click', function() {
    // fetch_('/login/home_viewprofile/',id_,cd_);
    openLoadingModal();
    fetch_('/edit/'+id_+'/'+cd_,id_,cd_);
  });
$(document).on('click','#view_home',function(){
    openLoadingModal();
    if (isPhoneSize()) {
        sideBar.classList.toggle('active');
    }
    fetch_('/Home/'+id_+'/'+cd_,id_,cd_);
});
  $(document).on('click','#view_Library',function(){
    openLoadingModal();
    if (isPhoneSize()) {
      sideBar.classList.toggle('active');
    }
    fetch_('/Library/'+id_+'/'+cd_,id_,cd_);
    activeContent('CertActive', 'CertData');
  });
  $(document).on('click','#view_class',function(){
    openLoadingModal();
    if (isPhoneSize()) {
      sideBar.classList.toggle('active');
    }
    fetch_('/Class/'+id_+'/'+cd_,id_,cd_);
  });
  $(document).on('click','#view_class_teacher',function(){
    openLoadingModal();
    if (isPhoneSize()) {
      sideBar.classList.toggle('active');
    }
    fetch_('/Class_teacher/'+id_+'/'+cd_,id_,cd_);
  });

  $(document).on('click','#_ret_Course',function(){
    openLoadingModal();
    fetch_('/Class/'+id_+'/'+cd_,id_,cd_);
  });

  $(document).on('click','#_ret_Course_teacher',function(){
    openLoadingModal();
    fetch_('/Class_teacher/'+id_+'/'+cd_,id_,cd_);
  });

  $(document).on('click','#calendar-container',function(){
    openLoadingModal();
    if (isPhoneSize()) {
      sideBar.classList.toggle('active');
    }
    fetch_('/calendar/'+id_+'/'+cd_,id_,cd_);
  });

  $(document).on('click','#_this_topic',function(){
    openLoadingModal();
    fetch_('/See_topics/'+id_+'/'+cd_,id_,cd_);
  });
  $(document).on('click','#see_course_here',function(){
    openLoadingModal();
    var data_course = event.target;
    fetch_('/See_courses/'+data_course.getAttribute('get_course_id')+'/'+id_+'/'+cd_,id_,cd_);
  });

  $(document).on('click','#see_course_here_teacher',function(){
    openLoadingModal();
    var data_course = event.target;
    fetch_('/See_courses_teacher/'+data_course.getAttribute('get_course_id')+'/'+id_+'/'+cd_,id_,cd_);
  });

    //for clicking the course
    $(document).on('click', '#classroom_cell', function(event) {
        // Check if the event target is not a button
        if (!$(event.target).is('button')) {
            var courseId = $(this).attr('courseid');
            show_con(courseId);
        }
    });


  $(document).on('click','#re_run_Course',function(){
    openLoadingModal();
    fetch_('/See_courses/'+id_+'/'+cd_,id_,cd_);
  });


  $(document).on('click','#Enrollist_',function(){
    // var data = event.target.getAttribute('get_course');
    // console.log(data);

    const get_values = {
      key1: event.target.getAttribute('get_course'),
      key2: id_,
    };
      $.ajax({
          type: 'POST',
          url: '/add_enroll/'+id_+'/'+cd_,
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
        data: get_values,
          success: function(response) {
            alert(response.message);
            if(response.message === 'Already Enrolled. Refresh the page to access.')
            {
              fetch_('/Class/'+id_+'/'+cd_,id_,cd_);
            }
          },
          error: function(error) {
            console.log(error);
          }
      });
  });

  $(document).on('click','#accept_enrollist',function(event){

    var data_=event.target.getAttribute('data-user');
      var data_2=event.target.getAttribute('data-courseid');


    const get_values = {
      key1: event.target.getAttribute('data-user'),
      key2: event.target.getAttribute('data-courseid'),
    };

    // console.log(data);
    const formData = new FormData();
    formData.append('course_id', data_2);

    $.ajax({
      type: 'POST',
      url: '/accept_enrollist/'+id_+'/'+cd_,
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      data: get_values,
      success: function(response) {
        alert(response.message);
        if(response.message === 'Accept Successfully')
        {
          fetch('/admin_Class_update_enrollist/'+data_+'/'+id_+'/'+cd_,
            {method: 'POST',
            headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')},
            body: formData
          })
          .then(response => {
            return response.text();
          })
            .then(data => {
                document.getElementById('fetch_components').innerHTML = data;
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }else{
            console.log('not accepted')
        }
      },
      error: function(error) {
        console.log(error);
      }
  });
  });



//functions

function fetch_(url) {
    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
    })
        .then(response => response.text())
        .then(data => {
            document.getElementById('fetch_components').innerHTML = data;
            if (url.startsWith('/See_courses/') || url.startsWith('/See_courses_teacher/') || url.startsWith('/viewfile/')) {
                showActivities();
            }
            if (url.startsWith('/See_courses/')){
                uploadReport();
            } else if (url.startsWith('/Home/')) {
                homeJS();
            }
            // history.pushState(null, '', url);
            closeLoadingModal();
        })
        .catch(error => {
            console.error('Error:', error);
        });

    window.addEventListener('popstate', function() {
        location.reload();
    });
}


function check_con_pass() {
  const password = document.getElementById("pass_word").value;
  const confirmPassword = document.getElementById("con_pass_word").value;
  const message = document.getElementById("passError");


  if (password === confirmPassword) {
      message.innerHTML = "Passwords match";
      message.style.color = "green";
  } else {
      message.innerHTML = "Passwords do not match";
      message.style.color = "red";
  }
}

function update_name()
{
    const dataToSend = {
        key1: document.getElementById('change_name').value,
      };

    if(dataToSend.key1)
      {
        openLoadingModal();
        $.ajax({
          type: 'POST',
          url: '/Edit_name/'+id_+'/'+cd_,
          headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          data: dataToSend,
          success: function(response) {
            console.log('Name Has Change!');
            alert(response.message);
            location.href= "/login_/user_page/id="+id_+"/cd="+cd_;
          },
          error: function(error) {
            console.error('Error sending data:', error);
          }
        });
      }else
      {
        alert("Please fill the text field.");
        closeLoadingModal();
      }

}

function update()
{
    const dataToSend = {
        key1: document.getElementById('old_pass_word').value,
        key2:  document.getElementById("id_get").value,
        key3: document.getElementById('con_pass_word').value,
      };
openLoadingModal();


    $.ajax({
        type: 'POST',
        url: '/Edit_prodile/'+id_+'/'+cd_,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        data: dataToSend,
        success: function(response) {
          console.log('Data sent successfully!');
          if(response.message !== "Please Fill all the Fields.")
          {
            document.getElementById('passError').innerText = response.message;
            document.getElementById('passError').style.color = 'red';
            closeLoadingModal();
          }else
          {
            document.getElementById('passError').innerText = response.message;
            closeLoadingModal();
          }

          if(response.message === "Success")
          {
            location.href= "/login_/user_page/id="+id_+"/cd="+cd_;
            closeLoadingModal();
          }else
          {
            document.getElementById('passError').innerText = response.message;
            closeLoadingModal();
          }

        },
        error: function(error) {
          console.error('Error sending data:', error);
        }
      });
}


function update_image()
{
      var image_ = new FormData();
      var get_image = document.getElementById('user_images_').files[0];
      image_.append('image', get_image);
      openLoadingModal();
    $.ajax({
        type: 'POST',
        url: '/Edit_picture/'+id_+'/'+cd_,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        data: image_,
        contentType: false,
        processData: false,
        success: function(response) {
          console.log('Data sent successfully!');
          if(response.message !== "No Uploaded File.")
          {
            location.href= "/login_/user_page/id="+id_+"/cd="+cd_;
            closeLoadingModal();
          }
          else
          {
            document.getElementById('message_update_image').innerText = response.message;
            closeLoadingModal();
          }

        },
        error: function( error) {
          closeLoadingModal();
          console.error('Error sending data:', error);
          document.getElementById('message_update_image').innerText = "Something went wrong, please try other image.";

        }
      });
}

// function loadScriptAfterAjax() {
//     var scripts = [ "js/libs/jquery.min.js",
//                             "js/libs/compatibility.js",
//                             "js/libs/mockup.min.js",
//                             "js/libs/pdf.min.js",
//                             "js/libs/pdf.worker.min.js",
//                             "js/dflip.min.js",
//                             "js/turn.min.js",
//                             "js/flipbook.js",
//                             ];
//
//     var loadedCountS = 0;
//     function loadScript(url) {
//         var script = document.createElement('script');
//         script.src = baseUrl + '/' + url;
//         script.onload = function() {
//             loadedCountS++;
//         };
//         script.onerror = function() {
//             console.error('Error loading script:', url);
//         };
//         document.body.appendChild(script);
//     }
//
//     scripts.forEach(function(url) {
//         loadScript(url);
//     });
// }

/**
 * ADMIN COURSE DELETE
 * **/
$(document).on('click','#delete__the_course',function(){
  var confirmDelete = confirm("Are you sure you want to delete this course?");

  if (confirmDelete) {
    openLoadingModal();
    var data = $(this).closest('.row_ad');
    const get_values = {
      key1: data[0].getAttribute('get_id_course'),
    };
      $.ajax({
          type: 'POST',
          url: '/delete_course/'+id_+'/'+cd_,
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
        data: get_values,
          success: function(response) {
              alert("Course deleted successfully!");
              fetch_('/change_course/'+id_+'/'+cd_,id_,cd_);
              console.log(response.message);

          },
          error: function(error) {
              alert("An error occurred while deleting the course. Please try again.");
              console.error(error);
          }
      });
  } else {

  }
});
/**
 * ADMIN UPDATE COURSE
 * **/
$(document).on('click','#update__the_course',function(event){
  var data = $(this).closest('.row_ad');
  // console.log(data[0].getAttribute('get_id_course'));

      const get_values = {
        key1: data[0].querySelector('#course').value,
        key2: data[0].querySelector('#description').value,
        key3: data[0].querySelector('#video_url').value,

        key6: data[0].getAttribute('get_id_course'),
    };

    const formData = new FormData();
    formData.append('key4', data[0].querySelector('#pdf_chg').files[0]);
    formData.append('key5', data[0].querySelector('#picture_chg').files[0]);

    for (const key in get_values) {
        formData.append(key, get_values[key]);
    }

    if (event.target.tagName === 'BUTTON') {
      openLoadingModal();
      $.ajax({
          type: 'POST',
          url: '/update_course/'+id_+'/'+cd_,
          headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          data: formData,
          processData: false,
          contentType: false,
          success: function(response) {

              alert(response.message);
              if('Course Update.' === response.message)
              {
                fetch_('/change_course/'+id_+'/'+cd_,id_,cd_);
              }
          },
          error: function(error) {
              alert("Something went wrong, please try again.");
                closeLoadingModal();
              console.log(error);
          }
      });
  }
});
/**
 * ADMIN ADD COURSE
 * **/
$(document).on('click','#_get_add_course',function(event){
  var data = $(this).closest('.row_ad');
  // console.log(data[0].querySelector('#course').value);
  const get_values = {
    key1: data[0].querySelector('#course').value,
    key2: data[0].querySelector('#description').value,
    key3: data[0].querySelector('#video_url').value,
  };
  const formData = new FormData();
  formData.append('key4', data[0].querySelector('#pdf_chg').files[0]);
  formData.append('key5', data[0].querySelector('#picture_chg').files[0]);

  for (const key in get_values) {
      formData.append(key, get_values[key]);
  }
  if (event.target.tagName === 'BUTTON') {
    openLoadingModal();
    $.ajax({
        type: 'POST',
        url: '/add_course/'+id_+'/'+cd_,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            alert(response.message);
            if('Course Added.' === response.message)
            {
              fetch_('/change_course/'+id_+'/'+cd_,id_,cd_);
            }
            closeLoadingModal();
        },
        error: function(error) {
            alert("Something went wrong, please try again.");
              closeLoadingModal();
            console.log(error);
        }
    });
}

});
/**
 * ADMIN DELETE COURSE
 * **/
$(document).on('click','#delete_course_list', function(){
    const formData = new FormData();
    var data1 = event.target.getAttribute('get_id_course');
    var data2 = event.target.getAttribute('get_id_course1');
    formData.append('key6', data1);

    if (event.target.tagName === 'BUTTON') {
        // console.log("Runing");

        var result = window.confirm('Are you sure you want to delete this activity?');

        if (result) {
            openLoadingModal();
            $.ajax({
                type: 'POST',
                url: '/admin_Class_Update_act_delete/'+id_+'/'+cd_,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    body: formData
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(data1);
                    if('Updated new Items' === response.message)
                    {
                        fetch_3('/admin_Class_update/'+id_+'/'+cd_,data2);
                    }
                    alert("Activity Deleted.");
                    closeLoadingModal();

                },
                error: function(error) {
                    alert("Something went wrong, please try again.");
                    closeLoadingModal();
                    console.log(error);
                }
            });

        } else {
            // User clicked "Cancel"
            // console.log('Activity deletion canceled');
        }

    }

});


$(document).on('click','#delete_course_list1', function(){
    const formData = new FormData();
    var data1 = event.target.getAttribute('get_id_course');
    var data3 = event.target.getAttribute('get_id_course3');
    formData.append('key6', data1);

    if (event.target.tagName === 'BUTTON') {
        // console.log("Runing");

        var result = window.confirm('Are you sure you want to delete this activity?');

        if (result) {
            openLoadingModal();
            $.ajax({
                type: 'POST',
                url: '/admin_Class_Update_act_delete/'+id_+'/'+cd_,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    body: formData
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(data1);
                    if('Updated new Items' === response.message)
                    {
                        fetch_3('/See_courses_teacher/'+data3+'/'+id_+'/'+cd_);
                    }
                    alert("Activity Deleted.");
                    closeLoadingModal();

                },
                error: function(error) {
                    alert("Something went wrong, please try again.");
                    closeLoadingModal();
                    console.log(error);
                }
            });

        } else {
            // User clicked "Cancel"
            // console.log('Activity deletion canceled');
        }

    }

});


function fetch_1(url)
{
  fetch(url,
  {method: 'POST',
  headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')},
})
.then(response => {
  return response.text();
})
  .then(data => {
      document.getElementById('fetch_components').innerHTML = data;
      closeLoadingModal();
  })
  .catch(error => {
      console.error('Error:', error);
  });

}
function fetch_2(url)
{
  var data=event.target.getAttribute('get_id_course');
  // console.log(data);
  const formData = new FormData();

  formData.append('key1', data);

  fetch(url,
  {method: 'POST',
  headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')},
  body: formData
})
.then(response => {
  return response.text();
})
  .then(data => {
      document.getElementById('fetch_components').innerHTML = data;
      closeLoadingModal();
  })
  .catch(error => {
      console.error('Error:', error);
  });
}


function fetch_3(url,data)
{

  // console.log(data);
  const formData = new FormData();

  formData.append('key1', data);

  fetch(url,
  {method: 'POST',
  headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')},
  body: formData
})
.then(response => {
  return response.text();
})
  .then(data => {
      document.getElementById('fetch_components').innerHTML = data;
      if (url.startsWith('/See_courses/') || url.startsWith('/See_courses_teacher/') || url.startsWith('/viewfile/')) {
          showActivities();
      }
      closeLoadingModal();
  })
  .catch(error => {
      console.error('Error:', error);
  });
}


$(document).on('click','#update_the_pdf_file', function(){

  const formData = new FormData();
  var data = $(this).closest('.row_course');

  var data1 = event.target.getAttribute('get_id_course');
  var data2 = event.target.getAttribute('get_id_course1');


  var fileList = data[0].querySelector('#activities').files;
  for (var i = 0; i < fileList.length; i++) {
    formData.append('key3[]', fileList[i]);
  }
  formData.append('key6', data1);

  // console.log(formData.getAll('key3[]'));

  if (event.target.tagName === 'BUTTON') {

  openLoadingModal();
  $.ajax({
    type: 'POST',
    url: '/admin_Class_Update_act_pdf/'+id_+'/'+cd_,
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        body: formData
    },
    data: formData,
    processData: false,
    contentType: false,
    success: function(response) {

      if('Success Updated' === response.message)
      {
        fetch_3('/admin_Class_update/'+id_+'/'+cd_,data2);
      }
      alert(response.message);
      closeLoadingModal();
    },
    error: function(error) {
        alert("Something went wrong, please try again.");
        closeLoadingModal();
        console.log(error);
    }
  });
}
});

$(document).on('click','#UpdatE_course_list', function(){
  const formData = new FormData();
  var data = $(this).closest('.row_course');
  // console.log(event.target.getAttribute('get_id_course1'));


  var data1 = event.target.getAttribute('get_act_id');
  var data2 = event.target.getAttribute('get_course_id');

  formData.append('key1', data1);
  formData.append('key2', data2);
  formData.append('key3', data[0].querySelector('#act_name').value);
  formData.append('key4', data[0].querySelector('#act_desc').value);
  formData.append('key5', data[0].querySelector('#act_link').value);

  if (event.target.tagName === 'BUTTON') {
    // console.log("Runing");
    openLoadingModal();
  $.ajax({
    type: 'POST',
    url: '/admin_Class_Update_act/'+id_+'/'+cd_,
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        body: formData
    },
    data: formData,
    processData: false,
    contentType: false,
    success: function(response) {
        console.log(data1);
        if('Updated new Items' === response.message)
        {
          fetch_3('/admin_Class_update/'+id_+'/'+cd_,data2);
        }
        alert(response.message);
        closeLoadingModal();

    },
    error: function(error) {
        alert("Something went wrong, please try again.");
        closeLoadingModal();
        console.log(error);
    }
  });
}

});
/**
 * ADMIN ADD NEW ACTIVITY
 * **/
$(document).on('click','#admin_add_activity', function(){
  const formData = new FormData();
  var data = $(this).closest('.row_course');
  // console.log(event.target.getAttribute('get_id_course'));
  var data1 = event.target.getAttribute('get_id_course');

    formData.append('key1', data1);
    formData.append('key3', data[0].querySelector('#act_name').value);
    formData.append('key4', data[0].querySelector('#act_desc').value);
    formData.append('key5', data[0].querySelector('#act_link').value);

  if (event.target.tagName === 'BUTTON') {
      // console.log("Runing");
      openLoadingModal();

    $.ajax({
      type: 'POST',
      url: '/admin_Class_add/'+id_+'/'+cd_,
      headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          body: formData
      },
      data: formData,
      processData: false,
      contentType: false,
      success: function(response) {
          alert(response.message);
          closeLoadingModal();
          if('Added new Items' === response.message)
          {
            fetch_3('/admin_Class_update/'+id_+'/'+cd_,data1);
          }
      },
      error: function(error) {
          alert("Something went wrong, please try again.");
          closeLoadingModal();
          console.log(error);
      }
    });
  }
});
/**
 * TEACHER ADD NEW ACTIVITY
 * **/
$(document).on('click','#teacher_add_activity', function(){
    const formData = new FormData();
    var data = $(this).closest('.row_course');
    // console.log(event.target.getAttribute('get_id_course'));
    var data1 = event.target.getAttribute('get_id_course');

    formData.append('key1', data1);
    formData.append('key3', data[0].querySelector('#act_name').value);
    formData.append('key4', data[0].querySelector('#act_desc').value);
    formData.append('key5', data[0].querySelector('#act_link').value);

    if (event.target.tagName === 'BUTTON') {
        // console.log("Runing");
        openLoadingModal();

        $.ajax({
            type: 'POST',
            url: '/admin_Class_add/'+id_+'/'+cd_,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                body: formData
            },
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                alert(response.message);
                closeLoadingModal();
                if('Added new Activity' === response.message)
                {
                    fetch_3('/See_courses_teacher/'+data1+'/'+id_+'/'+cd_);
                }
            },
            error: function(error) {
                alert("Something went wrong, please try again.");
                closeLoadingModal();
                console.log(error);
            }
        });
    }
});

$(document).on('click','#UpdatE_course_list_teacher', function(){
    const formData = new FormData();
    var data = $(this).closest('.row_course');
    // console.log(event.target.getAttribute('get_id_course1'));


    var data1 = event.target.getAttribute('get_act_id');
    var data2 = event.target.getAttribute('get_course_id');

    formData.append('key1', data1);
    formData.append('key2', data2);
    formData.append('key3', data[0].querySelector('#act_name').value);
    formData.append('key4', data[0].querySelector('#act_desc').value);
    formData.append('key5', data[0].querySelector('#act_link').value);

    if (event.target.tagName === 'BUTTON') {
      // console.log("Runing");
      openLoadingModal();
    $.ajax({
      type: 'POST',
      url: '/admin_Class_Update_act/'+id_+'/'+cd_,
      headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          body: formData
      },
      data: formData,
      processData: false,
      contentType: false,
      success: function(response) {
          console.log(data1);
          if('Updated new Items' === response.message)
          {
            fetch_3('/See_courses_teacher/'+data2+'/'+id_+'/'+cd_);
        }
          alert(response.message);
          closeLoadingModal();

      },
      error: function(error) {
          alert("Something went wrong, please try again.");
          closeLoadingModal();
          console.log(error);
      }
    });
  }

  });
/**
 * UPDATE ACTIVITY FILE
 * **/
$(document).on('click','#update_act_file',function(){
        var data = $(this).closest('.row_course');
        var get_file_name =  data[0].querySelector('#file_name').value;
        var get_file_id = $(this).data('file_id');
        var get_act_id = $(this).data('act_id');
        console.log(get_file_name,', ',get_file_id,' , ',get_act_id)
        openLoadingModal();
        $.ajax({
            type: 'POST',
            url: '/admin_act_file_update/'+id_+'/'+cd_,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            data: {
                get_file_name: get_file_name,
                get_file_id: get_file_id,
                get_act_id: get_act_id,
            },
            success: function(response) {
                alert("File updated successfully!");
                $('.list_of_act_file').html(response.html);
                console.log(response.message);
                closeLoadingModal();
            },
            error: function(error) {
                alert("An error occurred while updating the file. Please try again.");
                console.error(error);
                closeLoadingModal();
            }
        });
});
/**
 * DELETE ACTIVITY FILE
 * **/
$(document).on('click', '#del_act_file', function() {
    var confirmDelete = confirm("Are you sure you want to delete this activity file?");
    if (confirmDelete) {
        openLoadingModal();
        var get_file_id = $(this).data('file_id');
        var get_act_id = $(this).data('act_id');
        console.log(get_file_id,' , ',get_act_id)
        $.ajax({
            type: 'POST',
            url: '/delete_act_file/'+id_+'/'+cd_,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            data: { get_file_id: get_file_id,
                    get_act_id: get_act_id,
            },
            success: function(response) {
                alert("File deleted successfully!");
                $('.list_of_act_file').html(response.html);
                closeLoadingModal();
            },
            error: function(error) {
                alert("An error occurred while deleting the course. Please try again.");
                console.error(error);
            }
        });
    }
});
/**
 * ADMIN ADD ACTIVITY WORK
 * **/
$(document).on('click', '#admin_add_act_work', function() {
    const workForm = new FormData();
    var data = $(this).closest('.row_course');
    // console.log(event.target.getAttribute('get_id_course'));
    var data1 = event.target.getAttribute('get_act_id');

    workForm.append('key1', data1);
    workForm.append('key2', 'admin');
    workForm.append('key3', data[0].querySelector('#work_name').value);
    workForm.append('key4', data[0].querySelector('#work_desc').value);
    workForm.append('key5', data[0].querySelector('#work_timestamp').value);
    workForm.append('key6', data[0].querySelector('#work_type').value);



    if (event.target.tagName === 'BUTTON') {
        openLoadingModal();
        $.ajax({
            type: 'POST',
            url: '/admin_add_work/'+id_+'/'+cd_,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            data: workForm,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.message === 'Added New Activity Work'){
                    $('.list_of_act_work').html(response.html);
                    closeLoadingModal();
                }else{
                    alert(response.message);
                    closeLoadingModal();
                }
            },
            error: function(error) {
                alert("An error occurred while adding the work. Please try again.");
                console.error(error);
            }
        });
    }
});
/**
 * TEACHER ADD ACTIVITY WORK
 * **/
$(document).on('click', '#teacher_add_act_work', function() {
    const workForm = new FormData();
    var data = $(this).closest('.row_course');
    // console.log(event.target.getAttribute('get_id_course'));

    var data1 = $(this).data('act_id');
    var data2 = $(this).data('course_id');
    var work_type = data.find('#select_work_type').val();

    workForm.append('key1', data1);
    workForm.append('key2', 'teacher');
    workForm.append('key3', data[0].querySelector('#work_name').value);
    workForm.append('key4', data[0].querySelector('#work_desc').value);
    workForm.append('key5', data[0].querySelector('#work_timestamp').value);
    workForm.append('key7', work_type);
    workForm.append('key6', data2);
    console.log(work_type)
    var form_data = $(this).closest('._litable');
    var appendedContent = form_data.find('.assessment-content');
    var assess_name = appendedContent.find('#assess_name').val();
    var assess_details = appendedContent.find('#assess_details').val();
    workForm.append('q1', assess_name);
    workForm.append('q2', assess_details);
    appendedContent.find('#questions-container .question').each(function() {
        var questionText = $(this).find('textarea[name="assessment_question[]"]').val();
        var questionPoints = $(this).find('input[name="assessment_points[]"]').val();
        workForm.append('assessment_question[]', questionText);
        workForm.append('assessment_points[]', questionPoints);
    });
    for (var pair of workForm.entries()) {
        console.log(pair[0] + ', ' + pair[1]);
    }

    if (event.target.tagName === 'BUTTON') {
        openLoadingModal();
        $.ajax({
            type: 'POST',
            url: '/admin_add_work/'+id_+'/'+cd_,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            data: workForm,
            processData: false,
            contentType: false,
            success: function(response) {
                alert(response.message);
                closeLoadingModal();
                if (response.message === 'Added New Activity Work') {
                    alert(response.message)
                    hide_con(data1)
                $('.activities').html(response.html);
                    showActivities()
                closeLoadingModal();
            }
            },
            error: function(error) {
                alert("An error occurred while adding the work. Please try again.");
                console.error(error);
            }
        });
    }
});
/**
 * DELETE ACTIVITY WORK
 * **/
$(document).on('click', '#del_work', function() {
    var confirmDelete = confirm("Are you sure you want to delete this activity file?");
    if (confirmDelete) {
        openLoadingModal();
        var get_work_id = $(this).data('work_id');
        var get_act_id = $(this).data('act_id');
        $.ajax({
            type: 'POST',
            url: '/delete_work/'+id_+'/'+cd_,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            data: { get_work_id: get_work_id,
                get_act_id: get_act_id,
            },
            success: function(response) {
                alert("File deleted successfully!");
                $('.list_of_act_work').html(response.html);
                closeLoadingModal();
            },
            error: function(error) {
                alert("An error occurred while deleting the course. Please try again.");
                console.error(error);
            }
        });
    }
});
/**
 * UPDATE ACTIVITY WORK
 * **/
$(document).on('click','#update_work',function(){
    var data = $(this).closest('.row_course');
    var get_work_name =  data[0].querySelector('#work_name').value;
    var get_work_desc = data[0].querySelector('#work_desc').value;
    var get_work_id = $(this).data('work_id');
    var get_act_id = $(this).data('act_id');
    var get_deadline = data[0].querySelector('#work_timestamp').value;

    openLoadingModal();
    $.ajax({
        type: 'POST',
        url: '/admin_work_update/'+id_+'/'+cd_,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        data: {
            get_work_id: get_work_id,
            get_work_name: get_work_name,
            get_work_desc: get_work_desc,
            get_act_id: get_act_id,
            get_deadline: get_deadline,
        },
        success: function(response) {
            alert("File updated successfully!");
            $('.list_of_act_work').html(response.html);
            console.log(response.message);
            closeLoadingModal();
        },
        error: function(error) {
            alert("An error occurred while updating the file. Please try again.");
            console.error(error);
            closeLoadingModal();
        }
    });
});
/**
 * ADD ACTIVITY FILE
 * **/
$(document).on('click', '#add_activity_file', function(event) {
    const formData = new FormData();
    var data = $(this).closest('.row_course');
    var data1 = event.target.getAttribute('get_act_id');
    var key3 = data[0].querySelector('#file_name_add').value;

    formData.append('key2', data1);
    formData.append('key3', key3);
    console.log(data1)

    var fileInput = data[0].querySelector('#act_files_add');
    if (fileInput.files.length > 0) {
        for (var i = 0; i < fileInput.files.length; i++) {
            formData.append('key4[]', fileInput.files[i]);
        }
    } else {
        alert("Please select a file to upload.");
        return;
    }

    if (event.target.tagName === 'BUTTON') {
        openLoadingModal();

        $.ajax({
            type: 'POST',
            url: '/admin_act_file_add/' + id_ + '/' + cd_,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                alert("Added new Items");
                $('.list_of_act_file').html(response.html);
                closeLoadingModal();
            },
            error: function(error) {
                alert("Something went wrong, please try again.");
                closeLoadingModal();
                console.log(error);
            }
        });
    }
});

/**
 * ALLOCATE COURSE TO TEACHER
 * **/
$(document).on('click','#giving_access',function(){
  var data = event.target.getAttribute('get_the_teacher');
  var data1 = $(this).closest('.row_ad_');

  // console.log(data);

  const formData = new FormData();

  formData.append('key1', data);
  formData.append('key2', data1[0].querySelector('#select_subject').value);

  $.ajax({
    type: 'POST',
    url: '/get_the_teacher/'+id_+'/'+cd_,
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      body: formData
  },
  data: formData,
  processData: false,
  contentType: false,
    success: function(response) {
      alert(response.message);
      if(response.message === 'Course Assigned.')
      {
        fetch_('/change_course/'+id_+'/'+cd_,id_,cd_);
      }
    },
    error: function(error) {
      console.log(error);
    }
  });
});
/**
 * DEALLOCATE COURSE TO TEACHER
 * **/
$(document).on('click','#removing_access',function(){
  var data = event.target.getAttribute('get_the_teacher');
  var data1 = $(this).closest('.row_ad_');

  // console.log(data);

  const formData = new FormData();

  formData.append('key1', data);
  formData.append('key2', data1[0].querySelector('#select_subject').value);

  $.ajax({
    type: 'POST',
    url: '/get_the_teacher_removed/'+id_+'/'+cd_,
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      body: formData
  },
  data: formData,
  processData: false,
  contentType: false,
    success: function(response) {
      alert(response.message);
      if(response.message === 'Access Removed.')
      {
        fetch_('/change_course/'+id_+'/'+cd_,id_,cd_);
      }
    },
    error: function(error) {
      console.log(error);
    }
  });
});

/**
 * ALLOCATE COURSE TO TEACHER(REGISTRAR)
 * **/
$(document).on('click','#giving_access2',function(){
    var data = event.target.getAttribute('get_the_teacher');
    var data1 = $(this).closest('.row_ad_');

    // console.log(data);

    const formData = new FormData();

    formData.append('key1', data);
    formData.append('key2', data1[0].querySelector('#select_subject').value);

    $.ajax({
      type: 'POST',
      url: '/get_the_teacher/'+id_+'/'+cd_,
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        body: formData
    },
    data: formData,
    processData: false,
    contentType: false,
      success: function(response) {
        alert(response.message);
        if(response.message === 'Course Assigned.')
        {
          fetch_('/teacher_Details/' + id_ + '/' + cd_);
        }
      },
      error: function(error) {
        console.log(error);
      }
    });
  });
  /**
   * DEALLOCATE COURSE TO TEACHER(REGISTRAR)
   * **/
  $(document).on('click','#removing_access2',function(){
    var data = event.target.getAttribute('get_the_teacher');
    var data1 = $(this).closest('.row_ad_');

    // console.log(data);

    const formData = new FormData();

    formData.append('key1', data);
    formData.append('key2', data1[0].querySelector('#select_subject').value);

    $.ajax({
      type: 'POST',
      url: '/get_the_teacher_removed/'+id_+'/'+cd_,
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        body: formData
    },
    data: formData,
    processData: false,
    contentType: false,
      success: function(response) {
        alert(response.message);
        if(response.message === 'Access Removed.')
        {
          fetch_('/teacher_Details/' + id_ + '/' + cd_);
        }
      },
      error: function(error) {
        console.log(error);
      }
    });
  });
/**
 * VIDEO LINK
 * **/
  $(document).on('click','#get_to_video',function(){
    window.open($(this).data('get_window'));
  });
//make this dynamically get data?
/**
 * SWITCHING CLASS TABS
 * **/
function switchTab(tabName) {
    // Reset all tabs to initial state
    document.querySelectorAll('.tabcontainer .tabwrapper').forEach(tab => {
        tab.classList.remove('active');
    });

    // Hide all data sections
    document.querySelectorAll('.tabcontent').forEach(content => {
        content.style.display = 'none';
    });

    // Activate the clicked tab
    document.getElementById(tabName + 'Active').classList.add('active');

    // Show the corresponding data section
    document.getElementById(tabName + 'Data').style.display = 'block';

}

function switchTab2(tabName) {
    document.querySelectorAll('.tabcontainer2 .tabwrapper2').forEach(tab => {
        tab.classList.remove('active');
    });

    document.querySelectorAll('.tabcontent2').forEach(content => {
        content.style.display = 'none';
    });

    document.getElementById(tabName + 'Active').classList.add('active');

    var contentToShow = document.getElementById(tabName + 'Tab');
    if (contentToShow) {
        contentToShow.style.display = 'block';
    } else {
        console.error('Element with ID ' + tabName + 'Tab does not exist.');
    }
}


/**
 * LOADING MODAL FUNCTIONS
 * **/
function openLoadingModal() {
  document.getElementById('loading-modal').style.display = 'block';
}

function closeLoadingModal() {
  document.getElementById('loading-modal').style.display = 'none';
}


function closeLoadingModal1() {
  document.getElementById('resset-modal').style.display = 'none';
}

$(document).on('click', '#exit_modal', function(){
    closeLoadingModal1();
});


function openLoadingModal1() {
    document.getElementById('resset-modal').style.display = 'block';

}

/**
 * ADMIN RESET PASSWORD
 * **/
$(document).on('click', '#resset_pass_user_columns', function(){


  // var data = $(this).closest('.row_user_data');
  const formData = new FormData();
  formData.append('key1', event.target.getAttribute('get_the_user'));

  var confirmDelete = confirm("Are you sure you want to reset the password");
  if(confirmDelete)
  {
    openLoadingModal1();
    $.ajax({
      type: 'POST',
      url: '/changes_user_management_resset/'+id_+'/'+cd_,
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        body: formData
    },
    data: formData,
    processData: false,
    contentType: false,
      success: function(response) {
        document.getElementById('resset-pass').innerHTML = response.show_resset_password;
        if(response.message === 'User Updated')
        {
          fetch_('/changes_user_management/'+id_+'/'+cd_,id_,cd_);
        }
      },
      error: function(error) {
        console.log(error);
      }
    });
  }else{

  }
});
/**
 * ADMIN UPDATE USER DETAILS
 * **/
$(document).on('click', '#update_user_columns', function(){
  openLoadingModal();
  var data = $(this).closest('.row_user_data');

  // console.log();
  const formData = new FormData();

  formData.append('key1', data[0].querySelector('#get_update_type').value);
  formData.append('key2', data[0].querySelector('#change_status').value);
  formData.append('key3', event.target.getAttribute('get_the_user'));

  $.ajax({
    type: 'POST',
    url: '/changes_user_management_update/'+id_+'/'+cd_,
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      body: formData
  },
  data: formData,
  processData: false,
  contentType: false,
    success: function(response) {
      alert(response.message);
      if(response.message === 'User Updated')
      {
        fetch_('/changes_user_management/'+id_+'/'+cd_,id_,cd_);
      }
    },
    error: function(error) {
      console.log(error);
    }
  });
});
/**
 * ADMIN ACTIVATE ALL USERS
 * **/
$(document).on('click','#active_all',function(){
  const formData = new FormData();
  formData.append('key1', event.target.getAttribute('get_att'));
  openLoadingModal();

    $.ajax({
      type: 'POST',
      url: '/changes_user_management_active_pending_all/'+id_+'/'+cd_,
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        body: formData
    },
    data: formData,
    processData: false,
    contentType: false,
      success: function(response) {
        alert(response.message);

        closeLoadingModal();
        if(response.message === 'User Updated')
        {
          fetch_('/changes_user_management/'+id_+'/'+cd_,id_,cd_);
        }
      },
      error: function(error) {
        console.log(error);
      }
    });
});
/**
 * ADMIN SET ALL USERS TO PENDING
 * **/
$(document).on('click','#pending_all',function(){
  const formData = new FormData();
  formData.append('key1', event.target.getAttribute('get_att'));
  openLoadingModal();

    $.ajax({
      type: 'POST',
      url: '/changes_user_management_active_pending_all/'+id_+'/'+cd_,
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        body: formData
    },
    data: formData,
    processData: false,
    contentType: false,
      success: function(response) {
        alert(response.message);
        closeLoadingModal();
        if(response.message === 'User Updated')
        {
          fetch_('/changes_user_management/'+id_+'/'+cd_,id_,cd_);
        }
      },
      error: function(error) {
        console.log(error);
      }
    });
});

function fetch_4(url) {
    $.ajax({
        type: 'GET',
        url: url,
        success: function (response) {
            if (response.html) {
                $('#ActivitiesData').html(response.html);
                showActivities()
            } else {
                $('#ActivitiesData').html('<p>No files found for this activity</p>');
            }
            closeLoadingModal();
        },
        error: function (error) {
            console.log(error);
            closeLoadingModal();
        }
    });
}

/**
 * USER UPLOAD ACTIVITY WORK
 * **/
$(document).on('click', '#upload_their_act_in', function() {
    const formData = new FormData();
    var data = $(this).closest('._li3');

    var get_course_id = $(this).data('course_id');
    var get_act_id = $(this).data('act_id');
    formData.append('key1', id_);
    formData.append('key2', get_act_id);
    formData.append('key3', data[0].querySelector('#course_activities').files[0]);
    formData.append('key4', $(this).data('work_id'));
    formData.append('key5', $(this).data('deadline'));
    formData.append('key6', get_course_id);


    if (event.target.tagName === 'BUTTON') {
        openLoadingModal();

        $.ajax({
            type: 'POST',
            url: '/course_add_activity/' + $(this).data('act_id') + '/' + id_ + '/' + cd_,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                alert(response.message);
                if (response.message === 'Work Submitted' || response.message === 'Work Updated') {
                    // Convert FormData to query parameters
                    const queryParams = new URLSearchParams();
                    for (const [key, value] of formData.entries()) {
                        queryParams.append(key, value);
                    }

                    fetch_4('/user_get_work/' + get_act_id + '/' + id_ + '/' + cd_ + '?' + queryParams.toString());
                    closeLoadingModal();
                }
            },
            error: function(error) {
                console.log(error);
                closeLoadingModal();
            }
        });
    }
});
/**
 * USER UPLOAD ACTIVITY WORK
 * **/
$(document).on('click', '#upload_answers', function() {
    const formData = new FormData();
    var data = $(this).closest('._li3');

    var get_assessment_id = $(this).data('assessment_id');
    var get_act_id = $(this).data('act_id');
    var get_course_id = $(this).data('course_id');
    formData.append('key1', id_);
    formData.append('key2', get_act_id);
    formData.append('key3', get_assessment_id);
    formData.append('key4', $(this).data('deadline'));
    formData.append('key5', $(this).data('work_type'));
    data.find('textarea[name^="answers"]').each(function() {
        var answerId = $(this).attr('name').match(/\d+/)[0];
        formData.append('answers[' + answerId + ']', $(this).val());
    });
    formData.append('key6', get_course_id);
    formData.append('key7', $(this).data('work_id'));

    for (var pair of formData.entries()) {
        console.log(pair[0] + ', ' + pair[1]);
    }

    if (event.target.tagName === 'BUTTON') {
        openLoadingModal();

        $.ajax({
            type: 'POST',
            url: '/user_submit_answers/' + $(this).data('act_id') + '/' + id_ + '/' + cd_,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                alert(response.message);
                if (response.message === 'Updated User Submission') {
                    const queryParams = new URLSearchParams();
                    for (const [key, value] of formData.entries()) {
                        queryParams.append(key, value);
                    }
                    fetch_4('/user_get_work/' + get_act_id + '/' + id_ + '/' + cd_ + '?' + queryParams.toString());
                    closeLoadingModal();
                }
            },
            error: function(error) {
                console.log(error);
                closeLoadingModal();
            }
        });
    }
});
/**
 *
 * **/
$(document).on("keydown", ".textarea_take_whitespace",function(){
  if (event.key === 'Tab') {
    event.preventDefault();
    var start = this.selectionStart;
    var end = this.selectionEnd;

    this.value = this.value.substring(0, start) + '\t' + this.value.substring(end);

    this.selectionStart = this.selectionEnd = start + 1;
}
});

/**
 * SWITCHING LIBRARY TABS
 * **/
// library functions
function activeContent(tabId, contentId) {
    // Remove active class from all tabs and hide all content
    const tabs = document.querySelectorAll('.tab');
    tabs.forEach(tab => tab.classList.remove('ClassTabActive'));

    const contents = document.querySelectorAll('.content > div');
    contents.forEach(content => content.classList.remove('active'));

    // Add active class to the clicked tab and show the corresponding content
    document.getElementById(tabId).classList.add('ClassTabActive');
    document.getElementById(contentId).classList.add('active');
    $(document).ready(function() {
        var progress_content = $('#progress_content');
        var progress = progress_content.attr('aria-valuenow');
        progress_content.css('width', progress + '%').text(progress + '%');
    });
}

/**
 * USER TOGGLE BAR FUNCTIONS
 * **/
function showActivities() {
    const bars = document.querySelectorAll('.toggle-bar');

    bars.forEach(bar => {
        bar.addEventListener('click', function() {
            const content = this.nextElementSibling;

            if (content.classList.contains('toggle-content')) {
                if (content.classList.contains('active')) {
                    content.classList.remove('active');
                    setTimeout(() => {
                        content.style.display = 'none';
                        this.classList.remove('active');
                    }, 500);
                } else {
                    content.style.display = 'block';
                    setTimeout(() => {
                        content.classList.add('active');
                        this.classList.add('active');
                    }, 10);
                }
            }
        });
    });
}
/**
 * USER UPLOAD DAILY REPORT
 * **/
function uploadReport(){
    const dropArea = document.getElementById('drop-area');
    const fileInput = document.getElementById('activities');
    const button = document.getElementById('pass_your_daily');
    const fileDetails = document.getElementById('file-details');

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => dropArea.classList.add('dragover'), false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => dropArea.classList.remove('dragover'), false);
    });

    dropArea.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        const files = dt.files;
        handleFiles(files);
    });

    dropArea.addEventListener('click', () => fileInput.click());

    fileInput.addEventListener('change', (e) => {
        const files = e.target.files;
        handleFiles(files);
    });
    button.addEventListener('click',function(event){
        event.stopPropagation();
        const formData = new FormData();

        var data = $(this).closest('.uploadReport');
        var get_course = $(this).data('course_id');
        formData.append('key1', id_);
        formData.append('key2', get_act_id);
        formData.append('key2', event.target.getAttribute('get_course'));
        formData.append('key3', data[0].querySelector('#activities').files[0]);
        formData.append('key4', event.target.getAttribute('get_pdf_daily'));
        formData.append('key6', get_course_id);

        if (event.target.tagName === 'BUTTON') {
            openLoadingModal();

            $.ajax({
                type: 'POST',
                url: '/See_courses_dailly/'+event.target.getAttribute('get_course')+'/'+id_+'/'+cd_,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    body: formData
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    alert(response.message);
                    closeLoadingModal();
                    if('Daily Record is Updated' || 'Daily Record Created' === response.message)
                    {
                        const queryParams = new URLSearchParams();
                        for (const [key, value] of formData.entries()) {
                            queryParams.append(key, value);
                        }
                        fetch_4('/user_get_work/' + get_course + '/' + id_ + '/' + cd_ + '?' + queryParams.toString());
                    }
                },
                error: function(error) {
                    alert("Something went wrong, please try again.");
                    closeLoadingModal();
                    console.log(error);
                }
            });
        }
    });

    function handleFiles(files) {
        if (files.length > 0) {
            const file = files[0];
            fileDetails.innerHTML = `<span class="fa-solid fa-book-journal-whills"></span>
                                              <p>Selected file: ${file.name}</p>`
        } else {
            fileDetails.innerHTML = `<span class="fa-solid fa-file-arrow-up"></span>`
        }
    }
}
/**
 * ADMIN FETCH ACTIVITY FILES
 * **/
$(document).on('change', '#file_select_activity', function() {
    var activityId = $(this).val();
    // var courseId = $(this).find(':selected').data('course');
    if(activityId) {
        $.ajax({
            type: 'GET',
            url: '/get-activity-files'+'/'+id_+'/'+cd_,
            data: {
                key2: activityId,
            },
            success: function(data) {
                $('.list_of_act_file').html(data);
            },
            error: function(data) {
                console.log(data);
            }
        });
    } else {
        $('.list_of_act_file').html('<p>No files found for this activity</p>');
    }
});
/**
 * ADMIN FETCH ACTIVITY WORKS
 * **/
$(document).on('change', '#work_select_activity', function() {

    var activityId = $(this).val();
    var courseId = $(this).find(':selected').data('course');
    console.log(activityId,courseId)
    if(activityId) {
        $.ajax({
            type: 'GET',
            url: '/get-activity-works'+'/'+id_+'/'+cd_,
            data: {
                key2: activityId,
                key1: courseId,
            },
            success: function(data) {
                $('.list_of_act_work').html(data);
            },
            error: function(data) {
                console.log(data);
            }
        });
    } else {
        $('.list_of_act_work').html('<p>No files found for this activity</p>');
    }
});
/**
 * ADMIN FETCH GRADES PER ACTIVITY
 * **/
$(document).on('change', '#grades_select_activity', function() {

    var activityId = $(this).val();
    var courseId = $(this).find(':selected').data('course');
    if(activityId) {
        $.ajax({
            type: 'GET',
            url: '/get-graded-works'+'/'+id_+'/'+cd_,
            data: {
                key2: activityId,
                key1: courseId,
            },
            success: function(data) {
                $('.Li_of_submissions').html(data);
            },
            error: function(data) {
                console.log(data);
            }
        });
    } else {
        $('.Li_of_submissions').html('<p>No files found for this activity</p>');
    }
});
/**
 * VIEW FILE AS FLIPBOOK
 * **/
$(document).on('click', '#seeFlipbook', function() {
    var file_id = event.target.getAttribute('file_id');
    if (file_id) {
        var url = '/viewfile/' + file_id + '/' + id_ + '/' + cd_;
        window.open(url, '_blank');
    } else {
    }
});
/**
 * USER HOME FUNCTIONS
 * **/
function homeJS(){
let currentSlide = 0;
const slides = document.querySelectorAll('.carousel-item');
const totalSlides = slides.length;
const indicators = document.querySelectorAll('.carousel-indicators button');

function showSlide(index) {
    if (index < 0) {
        index = totalSlides - 1;
    } else if (index >= totalSlides) {
        index = 0;
    }

    // Remove active class from all slides and indicators
    slides.forEach(slide => {
        slide.classList.remove('active');
    });
    indicators.forEach(indicator => {
        indicator.classList.remove('active');
    });

    // Add active class to the current slide and indicator
    slides[index].classList.add('active');
    indicators[index].classList.add('active');

    currentSlide = index;
}

document.querySelector('.carousel-control-prev').addEventListener('click', function() {
    showSlide(currentSlide - 1);
});

document.querySelector('.carousel-control-next').addEventListener('click', function() {
    showSlide(currentSlide + 1);
});

indicators.forEach((indicator, index) => {
    indicator.addEventListener('click', function() {
        showSlide(index);
    });
});

}
/**
 * TEACHER GRADE ACTIVITY SUBMISSION
 * **/
$(document).on('click','#update_score',function(){
    var activityId = $(this).data('act_id');
    var courseId = $(this).data('course_id');
    var data = $(this).closest('.row_grades');
    var get_user_score = data[0].querySelector('#user_score').value;
    var get_comment = data[0].querySelector('#comment').value;
    var get_submssion_id = $(this).data('sub_id');
    var get_teacher = $(this).data('teacher_id');
    // console.log(activityId, courseId, get_user_score, get_comment, get_submssion_id, get_teacher)
    openLoadingModal();
    $.ajax({
        type: 'POST',
        url: '/teacher_update_grade/'+id_+'/'+cd_,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        data: {
            get_course_id: courseId,
            get_act_id: activityId,
            get_user_score: get_user_score,
            get_comment: get_comment,
            get_submssion_id: get_submssion_id,
            get_teacher: get_teacher,
        },
        success: function(response) {
            if (response.message === 'Updated User Submission') {
                alert("Submission updated successfully!");
                $('.Li_of_submissions').html(response.html);
                closeLoadingModal();
            }
            else{
                alert("Submission failed to update.");
            }
        },
        error: function(error) {
            alert("An error occurred while updating the file. Please try again.");
            console.error(error);
            closeLoadingModal();
        }
    });
});
/**
 * TEACHER GRADE QUIZ/EXAM SUBMISSION
 * **/
$(document).on('click', '#submit-all-answers', function() {
    var data = $(this).closest('#update-answers-form');
    var formData = data.serialize()
    var course_id = $(this).data('course_id');
    var act_id = $(this).data('activity_id');
    var sub_id = $(this).data('sub_id');
    var type = $(this).data('type');

    console.log(formData)

    $.ajax({
        type: 'POST',
        url: '/update-all-answers/'+act_id+'/'+course_id+'/'+type+'/'+sub_id+'/'+id_+'/'+cd_, // Define the route in your Laravel application
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        data: formData,
        success: function(response) {
            if (response.message === 'Answers updated successfully') {
                alert(response.message);
                $('.Li_of_submissions').html(response.html);
            }
        },
        error: function(error) {
            alert("An error occurred while updating the answers. Please try again.");
            console.error(error);
        }
    });
});


$(document).on('change', '#select_work_type', function() {
    $('.appended-content').remove();
    var data = $(this).closest('.row_course');
    var actId = data.find('#teacher_add_act_work').data('act_id');
    var table = $('#table_' + actId);
    var workType = $(this).val();
    var newDiv = $('<div class="appended-content"></div>');
    if (workType !== 'submission') {
        $.ajax({
            url: '/work/' + workType + '/' + id_ + '/' + cd_,
            type: 'GET',
            success: function(response) {
                newDiv.html(response);
                console.log(workType)
                console.log(table)
                table.after(newDiv);
            },
            error: function(xhr) {
                console.error('An error occurred:', xhr);
            }
        });
    } else {
        table.after(newDiv);
    }
});

var questionCount = 1;

function reassignQuestionNumbers() {
    $('#questions-container .question').each(function(index) {
        $(this).find('.question-label').text(`Question ${index + 1}:`);
        $(this).find('textarea').attr('id', `assessment_question_${index + 1}`);
        $(this).find('.points-label').attr('for', `assessment_points_${index + 1}`);
        $(this).find('input[type="number"]').attr('id', `assessment_points_${index + 1}`);
    });
}

$(document).on('click', '#add-question-button', function() {
    questionCount++;
    var newQuestion = `
        <div class="question">
            <label class="question-label" for="assessment_question_${questionCount}">Question ${questionCount}:</label>
            <textarea id="assessment_question_${questionCount}" name="assessment_question[]" rows="4" cols="50" placeholder="Enter Question"></textarea>
            <label class="points-label" for="assessment_points_${questionCount}">Points:</label>
            <input type="number" id="assessment_points_${questionCount}" name="assessment_points[]" min="0" placeholder="Enter Points">
            <button type="button" class="delete-button">Delete</button>
        </div>
    `;
    $('#questions-container').append(newQuestion);
    reassignQuestionNumbers();
});

$(document).on('click', '.delete-button', function() {
    $(this).closest('.question').remove();
    reassignQuestionNumbers();
});

// Calendar Activity Works
function work_data(button) {
    // Get attributes from button
    var work_deadline = button.getAttribute('data-deadline');
    var act_name = button.getAttribute('data-act-name');
    var course_name = button.getAttribute('data-course-name');
    var work_name = button.getAttribute('data-work-name');
    var work_desc = button.getAttribute('data-work-desc');

  // Get attributes from button
  var work_deadline = button.getAttribute('data-deadline');
  var work_day = button.getAttribute('data-due-day');
  var work_month = button.getAttribute('data-due-month');
  var work_year = button.getAttribute('data-due-year');
  var act_name = button.getAttribute('data-act-name');
  var work_name = button.getAttribute('data-work-name');
  var work_desc = button.getAttribute('data-work-desc');

    // Update input fields
    document.getElementById('day-deadline').value = work_deadline;
    document.getElementById('course-name').value = course_name;
    document.getElementById('activity-name').value = act_name;
    document.getElementById('work-name').value = work_name;
    document.getElementById('work-descript').value = work_desc;
  // Update input fields
  document.getElementById('day-deadline').value = work_month + "-" + work_day + "-" + work_year;
  document.getElementById('activity-name').value = act_name;
  document.getElementById('work-name').value = work_name;
  document.getElementById('work-descript').value = work_desc;
}



// Certificate Tab
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $(input).parent().find('img').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// document.getElementById('image-upload').onchange = function() {
//   readURL(this);
// };

function view_verf(button) {
    dataToSend = {
        key1: button.getAttribute('data-username'),
        key2: button.getAttribute('data-course-id'),
    }

    $.ajax({
        type: 'POST',
        url: '/view-certificate',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        data: dataToSend,
        success: function(response) {

        }, error: function(error) {

        }
    });
}













function generate_cerf(button) {
  let tr = $(button.closest('.cerf-stud-container'));
  let imageInput = tr.find('#image-upload');
  let imageData = imageInput.val();

  if(imageData) {
    dataToSend = {
      key1: button.getAttribute('data-username'),
      key2: button.getAttribute('data-course-id'),
      key3: imageData
    };

    console.log(dataToSend.key1);
    console.log(dataToSend.key2);
    console.log(dataToSend.key3);

    $.ajax({
      type: 'POST',
      url: '/teacher-geenrate-certificate',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      data: dataToSend,
      success: function(response) {
        console.log(response.message);
        if (response.message == 'Updated User Submission') {
          alert(response.message);
          openLoadingModal();
          console.log('after open loading');
          var data_course = event.target;
          fetch_('/See_courses_teacher/'+button.getAttribute('data-course-id')+'/'+id_+'/'+cd_,id_,cd_);
          console.log('success');
        } else if (response.message == 'Error Uploading E-Signature') {
          alert(response.message);
          console.log('in else of response');
        }
      },
      error: function(error) {
        console.log(error);
      }
    });
  } else {
    alert("Please upload your e-signature to generate certificate.");
  }
}

$(document).on('click', '#add_new_act', function(event) {
        var table_id = $(this).data('table_id');
        console.log(table_id)
        show_con(table_id);
});
$(document).on('click', '#close_add', function(event) {
    var table_id = $(this).data('table_id');
    hide_con(table_id);
});


$(document).on('click', '.edit-button', function() {

    // Show the update form by removing the 'active' class
    $('#_update_activity').removeClass('active');
});

$(document).on('click', '#close_update', function() {
    // Hide the update form by adding the 'active' class
    $('#_update_activity').addClass('active');
});

$(document).on('click', '.btn-edit-act', function() {

    // Show the update form by removing the 'active' class
    $('#_update_act_file').removeClass('active');
});

$(document).on('click', '#close_update', function() {
    // Hide the update form by adding the 'active' class
    $('#_update_act_file').addClass('active');
});
