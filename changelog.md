/****************************************************************************************/
/*                                                                                      */
/*  File Manager v2.0                                                                   */
/*  Author:         Mike Redmond                                                        */
/*  Date:           11/7/2014                                                           */
/*  Description:    File manager is a light weight, secure file hosting application.    */
/*                  Files are stored server side in any directory that is readable      */
/*                  by the web servive. A MySQL database is required on the backend     */
/*                  to store group information, users, and document path mapping.       */
/*                                                                                      */
/****************************************************************************************/

/*  Structure   */

*   The overall structure of the application has changed to promote a more modularized
    feel. 
    
    Views:
    Houses any and all reusable UI elements that can be displayed. These include headers, 
    footers, and content sections at the current iteration.
    
    Utilities:
    All functional files are stored within utilities along with the config.php file. These
    functions are responsible for sanitation, fetching, setting, and formatting all 
    content to be displayed.
    
    Stylesheets:
    Stores the CSS for the application (based on Foundation)
    
    Docs:
    This is the repository for housing all folders and files. This directory comes 
    installed in the application directory by default but can change by modifying the 
    DOCUMENT_ROOT_PREFIX define variable in the config.php.
    
    Assets:
    Houses all of the images and JS files for the application
    
*   Due to the structure change, DOCUMENT_ROOT_PREFIX was introduced to satisfy the
    disconnect between the functional files and the document repository. As a side 
    effect, this also allows the document repository to be moved to a different location
    with a correct DOCUMENT_ROOT_PREFIX supplied.
    

    
    
                    