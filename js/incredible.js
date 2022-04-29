const chooseTenant = (tenant_uuid) => {
  document.cookie = `wazo[tenant_uuid]=${tenant_uuid}`;
  location.reload();
}
