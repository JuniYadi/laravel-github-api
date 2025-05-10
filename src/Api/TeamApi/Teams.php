<?php

namespace JuniYadi\GitHub\Api\TeamApi;

trait Teams
{
    /**
     * List teams in an organization
     * 
     * @param string $org Organization name
     * @param array $options Additional options
     * @return array
     */
    public function getTeams(string $org, array $options = []): array
    {
        return $this->get("/orgs/{$org}/teams", $options);
    }

    /**
     * Create a team
     * 
     * @param string $org Organization name
     * @param string $name Team name
     * @param array $options Additional options
     * @return array
     */
    public function createTeam(string $org, string $name, array $options = []): array
    {
        $params = array_merge(['name' => $name], $options);
        return $this->post("/orgs/{$org}/teams", $params);
    }

    /**
     * Update a team
     * 
     * @param int $team_id Team ID
     * @param array $options Update options
     * @return array
     */
    public function updateTeam(int $team_id, array $options = []): array
    {
        return $this->patch("/teams/{$team_id}", $options);
    }

    /**
     * Delete a team
     * 
     * @param int $team_id Team ID
     * @return bool
     */
    public function deleteTeam(int $team_id): bool
    {
        return $this->delete("/teams/{$team_id}") === null;
    }

    /**
     * List team members
     * 
     * @param int $team_id Team ID
     * @param array $options Additional options
     * @return array
     */
    public function getTeamMembers(int $team_id, array $options = []): array
    {
        return $this->get("/teams/{$team_id}/members", $options);
    }

    /**
     * Add a team member
     * 
     * @param int $team_id Team ID
     * @param string $username GitHub username
     * @param array $options Additional options
     * @return bool
     */
    public function addTeamMember(int $team_id, string $username, array $options = []): bool
    {
        $response = $this->put("/teams/{$team_id}/memberships/{$username}", $options);
        return isset($response['state']);
    }
}