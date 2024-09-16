 <div class="container py-5">
     <h3 class="mb-4">Manage Student Status</h3>

     <!-- Currently Disabled Students -->
     <div class="mb-5">
         <h5>Currently Disabled Students</h5>
         <table class="table table-bordered table-striped">
             <thead>
                 <tr>
                     <th>Student Name</th>
                     <th>Student ID</th>
                     <th>Email</th>
                     <th>Reason</th>
                     <th>Disabled By</th>
                     <th>Date Disabled</th>
                     <th>Actions</th>
                 </tr>
             </thead>
             <tbody>
                 {{-- Dummy Disabled Students Data --}}
                 <tr>
                     <td>Kwame Nkrumah</td>
                     <td>STU-2023001</td>
                     <td>kwame.nkrumah@example.zm</td>
                     <td>Outstanding Fees</td>
                     <td>Admin Jane</td>
                     <td>2024-04-15</td>
                     <td>
                         <button class="btn btn-success btn-sm" disabled>Re-enable</button>
                         {{-- Placeholder for future functionality --}}
                     </td>
                 </tr>
                 <tr>
                     <td>Chanda Mwamba</td>
                     <td>STU-2023002</td>
                     <td>chanda.mwamba@example.zm</td>
                     <td>Academic Probation</td>
                     <td>Admin John</td>
                     <td>2024-05-10</td>
                     <td>
                         <button class="btn btn-success btn-sm" disabled>Re-enable</button>
                     </td>
                 </tr>
                 {{-- Add more dummy rows as needed --}}
             </tbody>
         </table>
     </div>