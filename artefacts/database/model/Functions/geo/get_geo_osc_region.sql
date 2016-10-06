CREATE OR REPLACE FUNCTION portal.get_geo_osc_region(idgeo SMALLINT) RETURNS TABLE (
	id_osc INTEGER,
	geo_localizacao GEOMETRY(Point,4674)
) AS $$
BEGIN
	RETURN QUERY
		SELECT
			vw_geo_osc.id_osc,
			vw_geo_osc.geo_localizacao
		FROM portal.vw_geo_osc
		WHERE vw_geo_osc.cd_regiao = idgeo;
	RETURN;
END;
$$ LANGUAGE 'plpgsql'
