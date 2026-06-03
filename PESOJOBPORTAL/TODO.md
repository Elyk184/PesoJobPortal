# TODO - Fix DMW "Download as PDF" not working

- [x] Update DMW builder view to use server-side download endpoint (submit form to `ofw.dmw-download`).
- [x] Remove/disable client-side `html2pdf` download JS from the DMW builder view.
- [x] Add `@csrf` and hidden inputs required by `OfwController@downloadDmwForm` validation (`request_details`, `signature_date`, `assistance[]`).
- [x] Ensure `narrative` textarea maps to `request_details` and that at least one assistance option is sent.

- [ ] (Optional after basic success) Add attachments mapping if backend keys are required for PDF generation.

- [ ] Test manually in DMW environment.

