<?php
require_once('../assets/db/db-config.php');

class DatabaseHandler
{
    private $db;

    public function __construct()
    {
        global $db;
        $this->db = $db;
    }

    public function getUsers()
    {
        $query = "SELECT id, name, mail, role, verified FROM users";
        $result = mysqli_query($this->db, $query);

        if (!$result) {
            die("Error fetching users: " . mysqli_error($this->db));
        }

        $users = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }

        return $users;
    }
    public function getUserInfo($id)
    {
        $query = "SELECT id, name, mail, role, is_active, verified, user_info.* FROM users 
                  RIGHT JOIN user_info ON (users.id = user_info.usr) WHERE users.id = ?";
        $stmt = mysqli_prepare($this->db, $query);

        if (!$stmt) {
            die("Error preparing statement: " . mysqli_error($this->db));
        }

        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        mysqli_stmt_close($stmt);

        return $user;
    }
    public function getNotices()
    {
        $query = "SELECT notice_id, title, visibility, date
                  FROM notice
                  ORDER BY date DESC";

        $result = mysqli_query($this->db, $query);

        if (!$result) {
            die("Error fetching notices: " . mysqli_error($this->db));
        }

        $notices = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $notices[] = $row;
        }

        return $notices;
    }

    public function getNotice($id = NULL)
    {
        if ($id === null) {
            $query = "SELECT notice_id, title, description, visibility, date, updated_by FROM notice";
        } else {
            $query = "SELECT notice_id, title, description, visibility, date, updated_by FROM notice WHERE notice_id=?";
        }

        $stmt = mysqli_prepare($this->db, $query);

        if (!$stmt) {
            die("Error preparing statement: " . mysqli_error($this->db));
        }

        if ($id !== null) {
            mysqli_stmt_bind_param($stmt, "i", $id);
        }

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $notice = mysqli_fetch_assoc($result);

        mysqli_stmt_close($stmt);

        return $notice;
    }

    public function getRolesCountWithTotalUsers()
    {
        $query = "SELECT role, COUNT(*) as count FROM users GROUP BY role";
        $result = mysqli_query($this->db, $query);

        if (!$result) {
            die("Error fetching roles count: " . mysqli_error($this->db));
        }

        $roles = [];
        $count = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $roles[] = $row['role'];
            $count[] = $row['count'];
        }

        $totalUsersQuery = "SELECT COUNT(*) as totalUsers FROM users";
        $totalUsersResult = mysqli_query($this->db, $totalUsersQuery);
        $totalUsersRow = mysqli_fetch_assoc($totalUsersResult);
        $totalUsersCount = $totalUsersRow['totalUsers'];

        return ['roles' => $roles, 'count' => $count, 'totalUsers' => $totalUsersCount];
    }

    public function getApplicationTypesCount()
    {
        $query = "SELECT application_type, COUNT(*) as count FROM applications WHERE status = 'pending' GROUP BY application_type";
        $result = mysqli_query($this->db, $query);

        if (!$result) {
            die("Error fetching application types count: " . mysqli_error($this->db));
        }

        $applicationTypes = [];
        $applicationCount = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $applicationTypes[] = $row['application_type'];
            $applicationCount[] = $row['count'];
        }

        $totalApplicationQuery = "SELECT COUNT(*) as totalpending FROM applications WHERE status = 'pending'";
        $totalApplicationResult = mysqli_query($this->db, $totalApplicationQuery);
        $totalApplicationRow = mysqli_fetch_assoc($totalApplicationResult);
        $totalApplicationCount = $totalApplicationRow['totalpending'];

        return ['applicationTypes' => $applicationTypes, 'count' => $applicationCount, 'totalcount' => $totalApplicationCount,];
    }

    public function getApplications()
    {
        $query = "SELECT application_id, application_type, status, applied_by, approved_by, date, description
                  FROM applications
                  WHERE status IN ('pending')
                  ORDER BY date DESC";

        $result = mysqli_query($this->db, $query);

        if (!$result) {
            die("Error fetching applications: " . mysqli_error($this->db));
        }

        $applications = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $applications[] = $row;
        }

        return $applications;
    }

    public function getApplication($id = null)
    {
        if ($id === null) {
            $query = "SELECT application_id, application_type, status, applied_by, approved_by, date, description FROM applications";
        } else {
            $query = "SELECT application_id, application_type, status, applied_by, approved_by, date, description FROM applications WHERE application_id=?";
        }

        $stmt = mysqli_prepare($this->db, $query);

        if (!$stmt) {
            die("Error preparing statement: " . mysqli_error($this->db));
        }

        if ($id !== null) {
            mysqli_stmt_bind_param($stmt, "i", $id);
        }

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $application = mysqli_fetch_assoc($result);

        mysqli_stmt_close($stmt);

        return $application;
    }
}
