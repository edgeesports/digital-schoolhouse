var FiltersEnabled = 0; // if your not going to use transitions or filters in any of the tips set this to 0
var spacer="&nbsp; &nbsp; &nbsp; ";

// email notifications to admin
notifyAdminNewMembers0Tip=["", spacer+"No email notifications to admin."];
notifyAdminNewMembers1Tip=["", spacer+"Notify admin only when a new member is waiting for approval."];
notifyAdminNewMembers2Tip=["", spacer+"Notify admin for all new sign-ups."];

// visitorSignup
visitorSignup0Tip=["", spacer+"If this option is selected, visitors will not be able to join this group unless the admin manually moves them to this group from the admin area."];
visitorSignup1Tip=["", spacer+"If this option is selected, visitors can join this group but will not be able to sign in unless the admin approves them from the admin area."];
visitorSignup2Tip=["", spacer+"If this option is selected, visitors can join this group and will be able to sign in instantly with no need for admin approval."];

// students table
students_addTip=["",spacer+"This option allows all members of the group to add records to the 'Students' table. A member who adds a record to the table becomes the 'owner' of that record."];

students_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Students' table."];
students_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Students' table."];
students_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Students' table."];
students_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Students' table."];

students_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Students' table."];
students_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Students' table."];
students_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Students' table."];
students_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Students' table, regardless of their owner."];

students_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Students' table."];
students_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Students' table."];
students_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Students' table."];
students_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Students' table."];

// teams table
teams_addTip=["",spacer+"This option allows all members of the group to add records to the 'Teams' table. A member who adds a record to the table becomes the 'owner' of that record."];

teams_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Teams' table."];
teams_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Teams' table."];
teams_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Teams' table."];
teams_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Teams' table."];

teams_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Teams' table."];
teams_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Teams' table."];
teams_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Teams' table."];
teams_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Teams' table, regardless of their owner."];

teams_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Teams' table."];
teams_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Teams' table."];
teams_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Teams' table."];
teams_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Teams' table."];

// schools table
schools_addTip=["",spacer+"This option allows all members of the group to add records to the 'Schools' table. A member who adds a record to the table becomes the 'owner' of that record."];

schools_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Schools' table."];
schools_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Schools' table."];
schools_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Schools' table."];
schools_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Schools' table."];

schools_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Schools' table."];
schools_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Schools' table."];
schools_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Schools' table."];
schools_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Schools' table, regardless of their owner."];

schools_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Schools' table."];
schools_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Schools' table."];
schools_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Schools' table."];
schools_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Schools' table."];

// help table
help_addTip=["",spacer+"This option allows all members of the group to add records to the 'FAQ' table. A member who adds a record to the table becomes the 'owner' of that record."];

help_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'FAQ' table."];
help_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'FAQ' table."];
help_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'FAQ' table."];
help_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'FAQ' table."];

help_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'FAQ' table."];
help_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'FAQ' table."];
help_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'FAQ' table."];
help_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'FAQ' table, regardless of their owner."];

help_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'FAQ' table."];
help_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'FAQ' table."];
help_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'FAQ' table."];
help_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'FAQ' table."];

// role_types table
role_types_addTip=["",spacer+"This option allows all members of the group to add records to the 'Role Types' table. A member who adds a record to the table becomes the 'owner' of that record."];

role_types_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Role Types' table."];
role_types_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Role Types' table."];
role_types_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Role Types' table."];
role_types_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Role Types' table."];

role_types_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Role Types' table."];
role_types_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Role Types' table."];
role_types_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Role Types' table."];
role_types_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Role Types' table, regardless of their owner."];

role_types_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Role Types' table."];
role_types_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Role Types' table."];
role_types_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Role Types' table."];
role_types_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Role Types' table."];

// roles table
roles_addTip=["",spacer+"This option allows all members of the group to add records to the 'Roles' table. A member who adds a record to the table becomes the 'owner' of that record."];

roles_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Roles' table."];
roles_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Roles' table."];
roles_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Roles' table."];
roles_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Roles' table."];

roles_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Roles' table."];
roles_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Roles' table."];
roles_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Roles' table."];
roles_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Roles' table, regardless of their owner."];

roles_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Roles' table."];
roles_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Roles' table."];
roles_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Roles' table."];
roles_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Roles' table."];

// games table
games_addTip=["",spacer+"This option allows all members of the group to add records to the 'Games' table. A member who adds a record to the table becomes the 'owner' of that record."];

games_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Games' table."];
games_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Games' table."];
games_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Games' table."];
games_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Games' table."];

games_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Games' table."];
games_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Games' table."];
games_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Games' table."];
games_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Games' table, regardless of their owner."];

games_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Games' table."];
games_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Games' table."];
games_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Games' table."];
games_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Games' table."];

// preliminaries table
preliminaries_addTip=["",spacer+"This option allows all members of the group to add records to the 'Preliminaries' table. A member who adds a record to the table becomes the 'owner' of that record."];

preliminaries_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Preliminaries' table."];
preliminaries_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Preliminaries' table."];
preliminaries_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Preliminaries' table."];
preliminaries_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Preliminaries' table."];

preliminaries_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Preliminaries' table."];
preliminaries_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Preliminaries' table."];
preliminaries_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Preliminaries' table."];
preliminaries_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Preliminaries' table, regardless of their owner."];

preliminaries_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Preliminaries' table."];
preliminaries_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Preliminaries' table."];
preliminaries_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Preliminaries' table."];
preliminaries_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Preliminaries' table."];

// regional_finals table
regional_finals_addTip=["",spacer+"This option allows all members of the group to add records to the 'Regional Finals' table. A member who adds a record to the table becomes the 'owner' of that record."];

regional_finals_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Regional Finals' table."];
regional_finals_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Regional Finals' table."];
regional_finals_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Regional Finals' table."];
regional_finals_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Regional Finals' table."];

regional_finals_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Regional Finals' table."];
regional_finals_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Regional Finals' table."];
regional_finals_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Regional Finals' table."];
regional_finals_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Regional Finals' table, regardless of their owner."];

regional_finals_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Regional Finals' table."];
regional_finals_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Regional Finals' table."];
regional_finals_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Regional Finals' table."];
regional_finals_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Regional Finals' table."];

// grand_final table
grand_final_addTip=["",spacer+"This option allows all members of the group to add records to the 'Grand Final' table. A member who adds a record to the table becomes the 'owner' of that record."];

grand_final_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Grand Final' table."];
grand_final_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Grand Final' table."];
grand_final_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Grand Final' table."];
grand_final_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Grand Final' table."];

grand_final_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Grand Final' table."];
grand_final_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Grand Final' table."];
grand_final_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Grand Final' table."];
grand_final_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Grand Final' table, regardless of their owner."];

grand_final_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Grand Final' table."];
grand_final_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Grand Final' table."];
grand_final_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Grand Final' table."];
grand_final_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Grand Final' table."];

/*
	Style syntax:
	-------------
	[TitleColor,TextColor,TitleBgColor,TextBgColor,TitleBgImag,TextBgImag,TitleTextAlign,
	TextTextAlign,TitleFontFace,TextFontFace, TipPosition, StickyStyle, TitleFontSize,
	TextFontSize, Width, Height, BorderSize, PadTextArea, CoordinateX , CoordinateY,
	TransitionNumber, TransitionDuration, TransparencyLevel ,ShadowType, ShadowColor]

*/

toolTipStyle=["white","#00008B","#000099","#E6E6FA","","images/helpBg.gif","","","","\"Trebuchet MS\", sans-serif","","","","3",400,"",1,2,10,10,51,1,0,"",""];

applyCssFilter();
