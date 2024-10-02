
 $(document).ready(function () {
     // alert('Jquery Loaded');
     $("#hostel_name").on("change", function () {
         // alert('Script running 2');
         var hostelId = $(this).val();

         if (hostelId) {
             $.ajax({
                 url: "{{ route('fetch.bedspaces') }}", // Correct route for fetching bedspaces
                 type: "GET",
                 data: {
                     hostel_id: hostelId,
                 },
                 success: function (response) {
                     if (response.status === "success") {
                         $("#bedspaceSelect").empty(); // Clear previous options
                         $("#bedspaceSelect").append(
                             '<option value="">Select bedspace no</option>'
                         );

                         // Populate bedspaces dynamically
                         $.each(response.bedspaces, function (key, bedspace) {
                             $("#bedspaceSelect").append(
                                 '<option value="' +
                                     bedspace.id +
                                     '">' +
                                     bedspace.bedspace_no +
                                     "</option>"
                             );
                         });
                     }
                 },
                 error: function (xhr) {
                     console.log("Error fetching bedspaces:", xhr.responseText);
                 },
             });
         } else {
             // If no hostel is selected, clear the bedspace dropdown
             $("#bedspaceSelect").empty();
             $("#bedspaceSelect").append(
                 '<option value="">Select bedspace no</option>'
             );
         }
     });
 });
