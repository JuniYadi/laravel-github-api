<?php

namespace JuniYadi\GitHub\Contracts;

interface TeamApiInterface
{
    /**
     * List teams in an organization
     * 
     * @param string $org Organization name
     * @param array $options Additional options
     * @return array
     */
    public function getTeams(string $org, array $options = []): array;

    /**
     * Create a team
     * 
     * @param string $org Organization name
     * @param string $name Team name
     * @param array $options Additional options
     * @return array
     */
    public function createTeam(string $org, string $name, array $options = []): array;

    /**
     * Update a team
     * 
     * @param int $team_id Team ID
     * @param array $options Update options
     * @return array
     */
    public function updateTeam(int $team_id, array $options = []): array;

    /**
     * Delete a team
     * 
     * @param int $team_id Team ID
     * @return bool
     */
    public function deleteTeam(int $team_id): bool;

    /**
     * List team members
     * 
     * @param int $team_id Team ID
     * @param array $options Additional options
     * @return array
     */
    public function getTeamMembers(int $team_id, array $options = []): array;

    /**
     * Add a team member
     * 
     * @param int $team_id Team ID
     * @param string $username GitHub username
     * @param array $options Additional options
     * @return bool
     */
    public function addTeamMember(int $team_id, string $username, array $options = []): bool;
}